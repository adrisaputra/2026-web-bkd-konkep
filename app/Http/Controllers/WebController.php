<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Faq;
use App\Models\LegalProduct;
use App\Models\News;
use App\Models\Profile;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Transparency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WebController extends Controller
{
    public function index()
    {
        $slider = Slider::get();
        $profile = Profile::where('menu', 'opening_speech')->first();
        $news = News::latest()->take(3)->get();

        return view('pages.home', compact('slider', 'profile', 'news'));
    }

    public function profile()
    {
        if (request()->is('page-history')) {
            $head = 'Profil Instansi';
            $title = 'Sejarah Instansi';
            $profile = Profile::where('menu', 'history')->first();
        } elseif (request()->is('page-vision-mission')) {
            $head = 'Arah Kebijakan';
            $title = 'Visi & Misi BKD Kabupaten Konawe Kepulauan';
            $profile = Profile::where('menu', 'vision_mission')->first();
        } elseif (request()->is('page-main-tasks')) {
            $head = 'Tugas & Fungsi';
            $title = 'Tugas Pokok & Fungsi (Tupoksi)';
            $profile = Profile::where('menu', 'main_tasks')->first();
        } elseif (request()->is('page-structure')) {
            $head = 'Kelembagaan';
            $title = 'Struktur Organisasi';
            $profile = Profile::where('menu', 'structure')->first();
        }

        return view('pages.profile', compact('head', 'title', 'profile'));
    }

    public function service(): View
    {
        $pages = [
            'page-promotion' => ['head' => 'Layanan Kepegawaian', 'menu' => 'promotion'],
            'page-retirement' => ['head' => 'Layanan Kepegawaian', 'menu' => 'retirement'],
            'page-leave' => ['head' => 'Layanan Kepegawaian', 'menu' => 'leave'],
            'page-transfer' => ['head' => 'Layanan Kepegawaian', 'menu' => 'transfer'],
            'page-discipline' => ['head' => 'Layanan Kepegawaian', 'menu' => 'discipline'],
        ];
        $page = request()->segment(1);

        abort_unless(isset($pages[$page]), 404);

        $head = $pages[$page]['head'];
        $service = Service::where('menu', $pages[$page]['menu'])->firstOrFail();
        $title = $service->title;
        $serviceUrl = $service->url;

        return view('pages.service', compact('head', 'title', 'service', 'serviceUrl'));
    }

    public function announcement(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');

        $announcementsQuery = Announcement::query()->latest();

        if ($search !== '') {
            $announcementsQuery->where(function ($query) use ($search): void {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('text', 'like', '%'.$search.'%');
            });
        }

        $announcements = $announcementsQuery
            ->paginate(5)
            ->withQueryString();

        return view('pages.announcement', compact('announcements', 'search'));
    }

    public function legal_product(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');

        $legalProductsQuery = LegalProduct::query()->orderByDesc('id');

        if ($search !== '') {
            $legalProductsQuery->where(function ($query) use ($search): void {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('text', 'like', '%'.$search.'%');
            });
        }

        $legalProducts = $legalProductsQuery
            ->paginate(5)
            ->withQueryString();

        return view('pages.legal_product', compact('legalProducts', 'search'));
    }

    public function download_legal_product(LegalProduct $legalProduct)
    {
        $path = 'upload/legal_product/'.$legalProduct->file;

        abort_unless($legalProduct->file && Storage::disk('public')->exists($path), 404);

        DB::table($legalProduct->getTable())
            ->where($legalProduct->getKeyName(), $legalProduct->getKey())
            ->update(['count_view' => DB::raw('COALESCE(count_view, 0) + 1')]);

        return Storage::disk('public')->download($path, $legalProduct->title.'.pdf');
    }

    public function faq()
    {
        $faqs = Faq::query()->orderBy('id')->get();

        return view('pages.faq', compact('faqs'));
    }

    public function accountability(string $category): View
    {
        $categories = [
            'lakip' => [
                'view' => 'lakip',
                'title' => 'LAKIP',
                'eyebrow' => 'Akuntabilitas Kinerja',
                'heading' => 'Laporan Kinerja (LAKIP) BKD',
                'icon' => 'fa-file-invoice',
                'description' => 'Sebagai bentuk pertanggungjawaban atas pencapaian kinerja instansi pemerintah, BKD Kabupaten Konawe Kepulauan menyusun Laporan Kinerja Instansi Pemerintah (LAKIP) setiap tahun anggaran.',
            ],
            'renstra' => [
                'view' => 'renstra',
                'title' => 'Renstra',
                'eyebrow' => 'Perencanaan Strategis',
                'heading' => 'Rencana Strategis (Renstra) & Renja',
                'icon' => 'fa-map',
                'description' => 'Dokumen Rencana Strategis (Renstra) BKD Kabupaten Konawe Kepulauan memuat visi, misi, tujuan, sasaran, strategi, dan kebijakan program kerja untuk periode lima tahun.',
            ],
            'zona_integritas' => [
                'view' => 'ziwbk',
                'title' => 'Zona Integritas',
                'eyebrow' => 'Integritas',
                'heading' => 'Zona Integritas (ZI) Menuju WBK / WBBM',
                'icon' => 'fa-award',
                'description' => 'Badan Kepegawaian Daerah Kabupaten Konawe Kepulauan berkomitmen mewujudkan Zona Integritas (ZI) menuju Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM).',
            ],
        ];

        abort_unless(isset($categories[$category]), 404);

        $categoryDetails = $categories[$category];
        unset($categoryDetails['view']);
        $transparencies = Transparency::query()
            ->select(['id', 'category', 'title', 'text', 'file', 'count_view'])
            ->where('category', $category)
            ->orderByDesc('id')
            ->get();

        return view('pages.transparency-'.$categories[$category]['view'], compact('category', 'categoryDetails', 'transparencies'));
    }
}
