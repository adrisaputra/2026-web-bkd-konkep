<?php

namespace App\Http\Controllers;

use App\Models\Transparency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class TransparencyController extends Controller
{
    private const CATEGORIES = [
        'lakip' => [
            'title' => 'LAKIP',
            'eyebrow' => 'Akuntabilitas Kinerja',
            'heading' => 'Laporan Kinerja (LAKIP) BKD',
            'icon' => 'fa-file-invoice',
            'description' => 'Sebagai bentuk pertanggungjawaban atas pencapaian kinerja instansi pemerintah, BKD Kabupaten Konawe Kepulauan menyusun Laporan Kinerja Instansi Pemerintah (LAKIP) setiap tahun anggaran.',
        ],
        'renstra' => [
            'title' => 'Renstra',
            'eyebrow' => 'Perencanaan Strategis',
            'heading' => 'Rencana Strategis (Renstra) & Renja',
            'icon' => 'fa-map',
            'description' => 'Dokumen Rencana Strategis (Renstra) BKD Kabupaten Konawe Kepulauan memuat visi, misi, tujuan, sasaran, strategi, dan kebijakan program kerja untuk periode lima tahun.',
        ],
        'zona_integritas' => [
            'title' => 'Zona Integritas',
            'eyebrow' => 'Integritas',
            'heading' => 'Zona Integritas (ZI) Menuju WBK / WBBM',
            'icon' => 'fa-award',
            'description' => 'Badan Kepegawaian Daerah Kabupaten Konawe Kepulauan berkomitmen mewujudkan Zona Integritas (ZI) menuju Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM).',
        ],
    ];

    // # Show Data
    public function index(string $category): View
    {
        $categoryDetails = $this->categoryDetails($category);
        $title = $categoryDetails['title'];

        return view('admin.transparency.index', compact('category', 'categoryDetails', 'title'));
    }

    // # Get Data
    public function get_transparency_index(Request $request, string $category): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);

        $counter = 1;
        $transparencies = Transparency::with('user')
            ->where('category', $category);

        return DataTables::of($transparencies)
            ->addIndexColumn()
            ->addColumn('number', function () use (&$counter) {
                return $counter++;
            })
            ->addColumn('user', function (Transparency $transparency) {
                return $transparency->user?->name ?? '';
            })
            ->addColumn('display_file', function (Transparency $transparency) {
                if (! $transparency->file) {
                    return '';
                }

                $fileUrl = asset('storage/upload/transparency/'.$transparency->category.'/'.$transparency->file);

                return '<a href="'.e($fileUrl).'" target="_blank" rel="noopener">Lihat PDF</a>';
            })
            ->addColumn('action', function (Transparency $transparency) {
                $id = (int) $transparency->id;

                $button = '<a href="#" onClick="getData('.$id.')" data-bs-toggle="modal" data-bs-target="#kt_modal_add_transparency" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                        </a>';
                $button .= '<a href="#" onclick="deleteData('.$id.')" class="ms-3" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </a>';

                return $button;
            })
            ->rawColumns(['display_file', 'action'])
            ->make(true);
    }

    public function validate(Request $request, string $category, string $action): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => $action === 'Simpan'
                ? ['required', 'mimes:pdf', 'max:5120']
                : ['nullable', 'mimes:pdf', 'max:5120'],
        ], [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        return response()->json(['success' => true]);
    }

    // # Save Data
    public function store(Request $request, string $category): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => ['required', 'mimes:pdf', 'max:5120'],
        ], [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid().'.'.$file->extension();
        $path = $file->storePubliclyAs('upload/transparency/'.$category, $fileName, 'public');

        if ($path === false) {
            throw new RuntimeException('File transparansi gagal disimpan.');
        }

        Transparency::create([
            'category' => $category,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'text' => $validated['text'],
            'file' => $fileName,
            'count_view' => 0,
            'user_id' => Auth::id(),
        ]);

        activity()->log('Create Data Transparency Category = '.$category);

        return response()->json(['success' => true, 'message' => 'Tambah Data Berhasil']);
    }

    // # Get Data
    public function edit(Request $request, string $category, int $id): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);

        $transparency = Transparency::where('category', $category)->findOrFail($id);

        return response()->json(['success' => true, 'data' => $transparency]);
    }

    // # Edit Data
    public function update(Request $request, string $category, Transparency $transparency): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);
        abort_unless($transparency->category === $category, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => ['nullable', 'mimes:pdf', 'max:5120'],
        ], [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        $transparency->title = $validated['title'];
        $transparency->slug = Str::slug($validated['title']);
        $transparency->text = $validated['text'];
        $oldFile = $transparency->file;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid().'.'.$file->extension();
            $path = $file->storePubliclyAs('upload/transparency/'.$category, $fileName, 'public');

            if ($path === false) {
                throw new RuntimeException('File transparansi gagal disimpan.');
            }

            $transparency->file = $fileName;
        }

        $transparency->save();

        if ($oldFile && $oldFile !== $transparency->file) {
            Storage::disk('public')->delete('upload/transparency/'.$category.'/'.$oldFile);
        }

        activity()->log('Edit Data Transparency With ID = '.$transparency->id);

        return response()->json(['success' => true, 'message' => 'Ubah Data Berhasil']);
    }

    // # Delete Data
    public function delete(Request $request, string $category, Transparency $transparency): JsonResponse
    {
        abort_unless($request->ajax(), 404);
        $this->categoryDetails($category);
        abort_unless($transparency->category === $category, 404);

        $file = $transparency->file;
        $transparency->delete();

        if ($file) {
            Storage::disk('public')->delete('upload/transparency/'.$category.'/'.$file);
        }

        activity()->log('Delete Data Transparency With ID = '.$transparency->id);

        return response()->json(['success' => true, 'message' => 'Hapus Data Berhasil']);
    }

    public function publicIndex(string $category): View
    {
        $categoryDetails = $this->categoryDetails($category);
        $transparencies = Transparency::where('category', $category)
            ->orderByDesc('id')
            ->get();

        return view('pages.transparansi-'.$this->publicPage($category), compact('category', 'categoryDetails', 'transparencies'));
    }

    public function download(string $category, Transparency $transparency): StreamedResponse
    {
        $this->categoryDetails($category);
        abort_unless($transparency->category === $category, 404);

        $path = 'upload/transparency/'.$category.'/'.$transparency->file;
        abort_unless($transparency->file && Storage::disk('public')->exists($path), 404);

        DB::table($transparency->getTable())
            ->where($transparency->getKeyName(), $transparency->getKey())
            ->update(['count_view' => DB::raw('COALESCE(count_view, 0) + 1')]);

        return Storage::disk('public')->download($path, $transparency->title.'.pdf');
    }

    /**
     * @return array{title: string, eyebrow: string, heading: string, icon: string, description: string}
     */
    private function categoryDetails(string $category): array
    {
        abort_unless(array_key_exists($category, self::CATEGORIES), 404);

        return self::CATEGORIES[$category];
    }

    private function publicPage(string $category): string
    {
        return match ($category) {
            'lakip' => 'lakip',
            'renstra' => 'renstra',
            'zona_integritas' => 'ziwbk',
        };
    }
}
