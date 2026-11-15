<?php

namespace Tests\Feature;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Transparency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransparencyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_the_transparency_admin_page(): void
    {
        $this->get('/transparency/lakip')
            ->assertRedirect('/');
    }

    public function test_only_supported_transparency_categories_are_available_in_admin(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->get('/transparency/not-a-category')
            ->assertNotFound();
    }

    public function test_store_saves_a_transparency_document_in_the_selected_category(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs($user)
            ->post('/transparency/renstra/store', [
                'title' => 'Rencana Strategis',
                'text' => 'Dokumen rencana strategis.',
                'file' => UploadedFile::fake()->create('renstra.pdf', 10, 'application/pdf'),
            ], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Tambah Data Berhasil',
            ]);

        $transparency = Transparency::query()->firstOrFail();
        $this->assertSame('renstra', $transparency->category);
        $this->assertSame('rencana-strategis', $transparency->slug);
        $this->assertSame($user->id, $transparency->user_id);
        $this->assertSame(0, $transparency->count_view);
        Storage::disk('public')->assertExists('upload/transparency/renstra/'.$transparency->file);
    }

    public function test_list_only_returns_documents_for_the_selected_category(): void
    {
        $user = User::factory()->create();
        $lakip = Transparency::create([
            'category' => 'lakip',
            'title' => 'Laporan Kinerja',
            'slug' => 'laporan-kinerja',
            'text' => 'Dokumen LAKIP',
            'file' => null,
            'count_view' => 0,
            'user_id' => $user->id,
        ]);
        Transparency::create([
            'category' => 'renstra',
            'title' => 'Rencana Strategis',
            'slug' => 'rencana-strategis',
            'text' => 'Dokumen Renstra',
            'file' => null,
            'count_view' => 0,
            'user_id' => $user->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->getJson('/transparency/lakip/list', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $lakip->id)
            ->assertJsonPath('data.0.title', 'Laporan Kinerja');
    }

    public function test_update_and_delete_cannot_access_a_document_from_another_category(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/transparency/renstra/rencana.pdf', '%PDF-1.4');
        $transparency = Transparency::create([
            'category' => 'renstra',
            'title' => 'Rencana Strategis',
            'slug' => 'rencana-strategis',
            'text' => 'Dokumen Renstra',
            'file' => 'rencana.pdf',
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->put('/transparency/lakip/edit/'.$transparency->id, [
                'title' => 'Judul lain',
                'text' => 'Isi lain',
            ], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->assertNotFound();

        $this->getJson('/transparency/lakip/delete/'.$transparency->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertNotFound();

        $this->assertDatabaseHas('transparencies', [
            'id' => $transparency->id,
            'title' => 'Rencana Strategis',
            'category' => 'renstra',
        ]);
        Storage::disk('public')->assertExists('upload/transparency/renstra/rencana.pdf');
    }

    public function test_update_replaces_the_pdf_and_updates_the_document(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/transparency/lakip/old.pdf', '%PDF-1.4 old');
        $transparency = Transparency::create([
            'category' => 'lakip',
            'title' => 'Laporan Lama',
            'slug' => 'laporan-lama',
            'text' => 'Isi lama',
            'file' => 'old.pdf',
            'count_view' => 4,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->put('/transparency/lakip/edit/'.$transparency->id, [
                'title' => 'Laporan Baru',
                'text' => 'Isi baru',
                'file' => UploadedFile::fake()->create('baru.pdf', 12, 'application/pdf'),
            ], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Ubah Data Berhasil',
            ]);

        $this->assertDatabaseHas('transparencies', [
            'id' => $transparency->id,
            'category' => 'lakip',
            'title' => 'Laporan Baru',
            'slug' => 'laporan-baru',
            'text' => 'Isi baru',
            'count_view' => 4,
        ]);
        Storage::disk('public')->assertMissing('upload/transparency/lakip/old.pdf');
        Storage::disk('public')->assertExists('upload/transparency/lakip/'.$transparency->fresh()->file);
    }

    public function test_delete_removes_the_document_and_its_pdf(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/transparency/zona_integritas/komitmen.pdf', '%PDF-1.4');
        $transparency = Transparency::create([
            'category' => 'zona_integritas',
            'title' => 'Komitmen Integritas',
            'slug' => 'komitmen-integritas',
            'text' => 'Dokumen komitmen.',
            'file' => 'komitmen.pdf',
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->getJson('/transparency/zona_integritas/delete/'.$transparency->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Hapus Data Berhasil',
            ]);

        $this->assertDatabaseMissing('transparencies', ['id' => $transparency->id]);
        Storage::disk('public')->assertMissing('upload/transparency/zona_integritas/komitmen.pdf');
    }

    public function test_validation_rejects_non_pdf_uploads(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->postJson('/transparency/lakip/validate/Simpan', [
                'title' => 'Laporan Kinerja',
                'text' => 'Isi laporan',
                'file' => UploadedFile::fake()->create('laporan.txt', 10, 'text/plain'),
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['file']);
    }

    public function test_public_page_lists_only_escaped_documents_for_its_category(): void
    {
        $user = User::factory()->create();
        $title = 'Dokumen <script>alert(1)</script>';
        Transparency::create([
            'category' => 'lakip',
            'title' => $title,
            'slug' => 'dokumen',
            'text' => '<script>alert(2)</script>',
            'file' => null,
            'count_view' => 0,
            'user_id' => $user->id,
        ]);
        Transparency::create([
            'category' => 'renstra',
            'title' => 'Rencana Strategis Rahasia',
            'slug' => 'rencana-strategis',
            'text' => 'Isi Renstra',
            'file' => null,
            'count_view' => 0,
            'user_id' => $user->id,
        ]);

        $this->get('/transparansi-lakip')
            ->assertOk()
            ->assertSee(e($title), false)
            ->assertDontSee($title, false)
            ->assertDontSee('<script>alert(2)</script>', false)
            ->assertDontSee('Rencana Strategis Rahasia');
    }

    public function test_all_public_category_pages_render_their_category_content(): void
    {
        $this->get('/transparansi-lakip')
            ->assertOk()
            ->assertSee('Laporan Kinerja (LAKIP) BKD');

        $this->get('/transparansi-renstra')
            ->assertOk()
            ->assertSee('Rencana Strategis (Renstra) & Renja');

        $this->get('/transparansi-ziwbk')
            ->assertOk()
            ->assertSee('Zona Integritas (ZI) Menuju WBK / WBBM')
            ->assertSee('Komitmen Pelayanan Bersih');
    }

    public function test_download_increments_the_count_and_rejects_other_categories(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/transparency/lakip/laporan.pdf', '%PDF-1.4');
        $transparency = Transparency::create([
            'category' => 'lakip',
            'title' => 'Laporan Kinerja',
            'slug' => 'laporan-kinerja',
            'text' => 'Dokumen LAKIP',
            'file' => 'laporan.pdf',
            'count_view' => null,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get('/transparansi/lakip/'.$transparency->id.'/download')
            ->assertOk();

        $this->assertDatabaseHas('transparencies', [
            'id' => $transparency->id,
            'count_view' => 1,
        ]);

        $this->get('/transparansi/renstra/'.$transparency->id.'/download')
            ->assertNotFound();
    }
}
