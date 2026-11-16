<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\LegalProduct;
use App\Models\News;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WebControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_galery_displays_albums_five_per_page(): void
    {
        Schema::create('albums', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title');
            $table->text('text');
            $table->string('cover');
            $table->timestamps();
        });

        foreach (range(1, 11) as $index) {
            Album::create([
                'title' => 'Album '.$index,
                'text' => 'Deskripsi album '.$index,
                'cover' => $index.'.webp',
                'created_at' => now()->subDays($index),
            ]);
        }

        $this->get('/page-galery')
            ->assertOk()
            ->assertViewIs('pages.galery')
            ->assertViewHas('albums', fn ($albums): bool => $albums->count() === 5)
            ->assertSee('Album 1')
            ->assertSee('Album 5')
            ->assertDontSee('Album 6')
            ->assertSee('storage/upload/album/1.webp', false)
            ->assertSee('page=2', false);

        $this->get('/page-galery?page=2')
            ->assertOk()
            ->assertViewHas('albums', fn ($albums): bool => $albums->count() === 5)
            ->assertSee('Album 6')
            ->assertSee('Album 10')
            ->assertDontSee('Album 11');

        $this->get('/page-galery?page=3')
            ->assertOk()
            ->assertViewHas('albums', fn ($albums): bool => $albums->count() === 1)
            ->assertSee('Album 11')
            ->assertDontSee('>Album 1</h2>', false);
    }

    public function test_news_search_matches_titles_and_content_and_paginates_five_per_page(): void
    {
        $this->createPublicLayoutSetting();
        $this->createNewsTable();

        $user = User::factory()->create();

        foreach (range(1, 9) as $index) {
            $newsItem = News::create([
                'title' => $index <= 3 ? 'Kebijakan ASN '.$index : 'Berita '.$index,
                'text' => $index >= 4 && $index <= 7
                    ? 'Informasi kebijakan untuk berita '.$index
                    : 'Isi berita '.$index,
                'cover' => $index.'.webp',
                'slug' => 'berita-'.$index,
                'user_id' => $user->id,
            ]);
            $newsItem->created_at = now()->subDays($index);
            $newsItem->save();
        }

        $this->get('/page-news?search=kebijakan')
            ->assertOk()
            ->assertViewIs('pages.news')
            ->assertViewHas('news', fn ($news): bool => $news->count() === 5)
            ->assertSee('Kebijakan ASN 1')
            ->assertSee('Berita 4')
            ->assertSee('Berita 5')
            ->assertDontSee('Berita 6')
            ->assertSee('search=kebijakan&amp;page=2', false);

        $this->get('/page-news?search=kebijakan&page=2')
            ->assertOk()
            ->assertViewHas('news', fn ($news): bool => $news->count() === 2)
            ->assertSee('Berita 6')
            ->assertSee('Berita 7')
            ->assertDontSee('Berita 8');
    }

    public function test_news_detail_displays_full_article_and_escapes_html(): void
    {
        $this->createPublicLayoutSetting();
        $this->createNewsTable();
        $user = User::factory()->create();

        News::create([
            'title' => 'Kegiatan Kepegawaian',
            'cover' => 'kegiatan.webp',
            'slug' => 'kegiatan-kepegawaian',
            'text' => '<p>Isi berita lengkap.</p><p><script>alert(1)</script>Informasi lanjutan.</p>',
            'user_id' => $user->id,
        ]);

        $this->get('/page-news-detail?q=kegiatan-kepegawaian')
            ->assertOk()
            ->assertViewIs('pages.news_detail')
            ->assertSee('Kegiatan Kepegawaian')
            ->assertSee('storage/upload/news/kegiatan.webp', false)
            ->assertSee('Isi berita lengkap.')
            ->assertSee('Informasi lanjutan.')
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('Kembali ke daftar berita');
    }

    public function test_news_detail_returns_not_found_for_unknown_slug(): void
    {
        $this->createNewsTable();

        $this->get('/page-news-detail?q=berita-tidak-ada')
            ->assertNotFound();
    }

    public function test_news_search_rejects_non_string_values(): void
    {
        $this->get('/page-news?search%5B%5D=Kebijakan')
            ->assertRedirect()
            ->assertSessionHasErrors('search');
    }

    public function test_announcement_pages_render_five_database_records_per_page(): void
    {
        Schema::create('announcements', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();
            $table->string('file')->nullable();
            $table->integer('count_view')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        foreach (range(1, 7) as $index) {
            $announcement = Announcement::create([
                'title' => 'Pengumuman '.$index,
                'slug' => 'pengumuman-'.$index,
                'text' => '<p>Isi pengumuman '.$index.'</p>',
                'file' => $index === 1 ? 'pengumuman.pdf' : null,
            ]);
            $announcement->created_at = now()->subDays($index);
            $announcement->save();
        }

        $this->get('/page-announcement?search=Pengumuman')
            ->assertOk()
            ->assertViewIs('pages.announcement')
            ->assertSee('Pengumuman 1')
            ->assertSee('Pengumuman 5')
            ->assertDontSee('Pengumuman 6')
            ->assertSee('search=Pengumuman&amp;page=2', false);

        $this->get('/info-pengumuman?search=Pengumuman&page=2')
            ->assertOk()
            ->assertSee('Pengumuman 6')
            ->assertSee('Pengumuman 7')
            ->assertDontSee('Pengumuman 1');
    }

    public function test_announcement_search_matches_title_or_text_and_returns_only_matching_records(): void
    {
        Schema::create('announcements', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();
            $table->string('file')->nullable();
            $table->integer('count_view')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Announcement::create([
            'title' => 'Seleksi ASN',
            'text' => 'Informasi tahap seleksi.',
        ]);
        Announcement::create([
            'title' => 'Jadwal Terbaru',
            'text' => 'Perubahan jadwal seleksi ASN daerah.',
        ]);
        Announcement::create([
            'title' => 'Informasi Diklat',
            'text' => 'Pendaftaran pelatihan kepemimpinan.',
        ]);

        $this->get('/info-pengumuman?search=seleksi')
            ->assertOk()
            ->assertSee('Seleksi ASN')
            ->assertSee('Jadwal Terbaru')
            ->assertDontSee('Informasi Diklat');
    }

    public function test_public_announcement_view_escapes_titles_and_displays_pdf_downloads(): void
    {
        Schema::create('announcements', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();
            $table->string('file')->nullable();
            $table->integer('count_view')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });

        Announcement::create([
            'title' => 'Pengumuman <script>alert(1)</script>',
            'slug' => 'pengumuman',
            'text' => '<p>Informasi pengumuman</p>',
            'file' => 'pengumuman.pdf',
        ]);

        $this->get('/info-pengumuman')
            ->assertOk()
            ->assertSee('Pengumuman &lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('Informasi pengumuman')
            ->assertSee('storage/upload/announcement/pengumuman.pdf', false);
    }

    public function test_legal_products_are_paginated_five_per_page_and_keep_the_search_query(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 7) as $index) {
            LegalProduct::create([
                'title' => 'Dokumen '.$index,
                'text' => 'Isi dokumen '.$index,
                'user_id' => $user->id,
            ]);
        }

        $this->get('/page-legal-product?search=Dokumen')
            ->assertOk()
            ->assertViewIs('pages.legal_product')
            ->assertSee('Dokumen 7')
            ->assertSee('Dokumen 3')
            ->assertDontSee('Dokumen 2')
            ->assertSee('search=Dokumen&amp;page=2', false);

        $this->get('/info-produkhukum?search=Dokumen&page=2')
            ->assertOk()
            ->assertViewHas('legalProducts', fn ($legalProducts): bool => $legalProducts->count() === 2
                && $legalProducts->pluck('title')->all() === ['Dokumen 2', 'Dokumen 1']);
    }

    public function test_legal_product_search_matches_title_or_text(): void
    {
        $user = User::factory()->create();

        LegalProduct::create([
            'title' => 'Peraturan ASN',
            'text' => 'Ketentuan kepegawaian',
            'user_id' => $user->id,
        ]);
        LegalProduct::create([
            'title' => 'Dokumen Lain',
            'text' => 'Peraturan tentang cuti',
            'user_id' => $user->id,
        ]);
        LegalProduct::create([
            'title' => 'Informasi Umum',
            'text' => 'Informasi tanpa kecocokan',
            'user_id' => $user->id,
        ]);

        $this->get('/page-legal-product?search=Peraturan')
            ->assertOk()
            ->assertSee('Peraturan ASN')
            ->assertSee('Dokumen Lain')
            ->assertDontSee('Informasi Umum');
    }

    public function test_legal_product_search_rejects_non_string_values(): void
    {
        $this->get('/page-legal-product?search%5B%5D=Peraturan')
            ->assertRedirect()
            ->assertSessionHasErrors('search');
    }

    private function createPublicLayoutSetting(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('application_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->timestamps();
        });

        Setting::create(['application_name' => 'Test Application']);
    }

    private function createNewsTable(): void
    {
        Schema::create('news', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('cover')->nullable();
            $table->string('slug')->nullable();
            $table->text('text')->nullable();
            $table->string('file')->nullable();
            $table->integer('count_view')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }
}
