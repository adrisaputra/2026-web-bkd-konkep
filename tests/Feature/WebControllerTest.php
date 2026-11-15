<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\LegalProduct;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WebControllerTest extends TestCase
{
    use RefreshDatabase;

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
}
