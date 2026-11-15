<?php

namespace App\Http\Controllers;

use App\Models\LegalProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use RuntimeException;
use Yajra\DataTables\Facades\DataTables;

class LegalProductController extends Controller
{
    // # Show Data
    public function index(): View
    {
        $title = 'Produk Hukum';

        return view('admin.legal_product.index', compact('title'));
    }

    // # Get Data
    public function get_legal_product_index(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $counter = 1;
        $legalProducts = LegalProduct::with('user')->limit(10);

        return DataTables::of($legalProducts)
            ->addIndexColumn()
            ->addColumn('number', function () use (&$counter) {
                return $counter++;
            })
            ->addColumn('user', function (LegalProduct $legalProduct) {
                return $legalProduct->user?->name ?? '';
            })
            ->addColumn('display_file', function (LegalProduct $legalProduct) {
                if (! $legalProduct->file) {
                    return '';
                }

                $fileUrl = asset('storage/upload/legal_product/'.$legalProduct->file);

                return '<a href="'.e($fileUrl).'" target="_blank" rel="noopener">Lihat PDF</a>';
            })
            ->addColumn('action', function (LegalProduct $legalProduct) {
                $id = (int) $legalProduct->id;

                $button = '<a href="#" onClick="getData('.$id.')" data-bs-toggle="modal" data-bs-target="#kt_modal_add_legal_product" title="Edit">
                            <i class="fa fa-edit text-success"></i>
                        </a>';
                $button .= '<a href="#" onclick="deleteData('.$id.')" class="ms-3" title="Hapus">
                            <i class="fa fa-trash text-danger"></i>
                        </a>';

                return $button;
            })
            ->rawColumns(['display_file', 'action'])
            ->make(true);
    }

    public function validate(Request $request, string $action): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => $action === 'Simpan'
                ? ['required', 'mimes:pdf', 'max:5120']
                : ['nullable', 'mimes:pdf', 'max:5120'],
        ];

        $request->validate($rules, [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        return response()->json(['success' => true]);
    }

    // # Save Data
    public function store(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => ['required', 'mimes:pdf', 'max:5120'],
        ], [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        $legalProduct = new LegalProduct;
        $legalProduct->fill([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'slug' => Str::slug($validated['title']),
            'count_view' => 0,
            'user_id' => Auth::id(),
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid().'.'.$file->extension();
        $path = $file->storePubliclyAs('upload/legal_product', $fileName, 'public');

        if ($path === false) {
            throw new RuntimeException('File produk hukum gagal disimpan.');
        }

        $legalProduct->file = $fileName;
        $legalProduct->save();

        activity()->log('Create Data Legal Product');

        return response()->json(['success' => true, 'message' => 'Tambah Data Berhasil']);
    }

    // # Get Data
    public function edit(Request $request, int $id): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $legalProduct = LegalProduct::findOrFail($id);

        return response()->json(['success' => true, 'data' => $legalProduct]);
    }

    // # Edit Data
    public function update(Request $request, LegalProduct $legalProduct): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'file' => ['nullable', 'mimes:pdf', 'max:5120'],
        ], [], [
            'title' => 'Judul',
            'text' => 'Isi',
            'file' => 'File PDF',
        ]);

        $legalProduct->title = $validated['title'];
        $legalProduct->text = $validated['text'];
        $legalProduct->slug = Str::slug($validated['title']);

        $oldFile = $legalProduct->file;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid().'.'.$file->extension();
            $path = $file->storePubliclyAs('upload/legal_product', $fileName, 'public');

            if ($path === false) {
                throw new RuntimeException('File produk hukum gagal disimpan.');
            }

            $legalProduct->file = $fileName;
        }

        $legalProduct->save();

        if ($oldFile && $oldFile !== $legalProduct->file) {
            Storage::disk('public')->delete('upload/legal_product/'.$oldFile);
        }

        activity()->log('Edit Data Legal Product With ID = '.$legalProduct->id);

        return response()->json(['success' => true, 'message' => 'Ubah Data Berhasil']);
    }

    // # Delete Data
    public function delete(Request $request, LegalProduct $legalProduct): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $file = $legalProduct->file;
        $legalProduct->delete();

        if ($file) {
            Storage::disk('public')->delete('upload/legal_product/'.$file);
        }

        activity()->log('Delete Data Legal Product With ID = '.$legalProduct->id);

        return response()->json(['success' => true, 'message' => 'Hapus Data Berhasil']);
    }

    public function upload_image(Request $request): string
    {
        $validated = $request->validate([
            'CKEditorFuncNum' => ['required', 'integer', 'min:0'],
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $file = $request->file('upload');
        $fileName = Str::uuid().'.webp';
        $image = (new ImageManager(new Driver))
            ->read($file->getRealPath())
            ->toWebp(75);

        $stored = Storage::disk('public')->put('upload/legal_product/content/'.$fileName, (string) $image);

        if (! $stored) {
            throw new RuntimeException('Gambar isi produk hukum gagal disimpan.');
        }

        $fileUrl = asset('storage/upload/legal_product/content/'.$fileName);
        $callback = (int) $validated['CKEditorFuncNum'];

        return '<script>window.parent.CKEDITOR.tools.callFunction('.$callback.', '.json_encode($fileUrl).', "Upload berhasil");</script>';
    }

    public function public_index(): View
    {
        $legalProducts = LegalProduct::query()
            ->select(['id', 'title', 'slug', 'text', 'file', 'count_view'])
            ->orderByDesc('id')
            ->get();

        return view('pages.info-produkhukum', compact('legalProducts'));
    }
}
