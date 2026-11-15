<?php

namespace Tests\Feature;

use App\Http\Middleware\RoleMiddleware;
use App\Models\LegalProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegalProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_the_admin_page(): void
    {
        $this->get('/legal_product')
            ->assertRedirect('/');
    }

    public function test_store_saves_a_legal_product_and_its_pdf(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs($user)
            ->post('/legal_product/store', [
                'title' => 'Peraturan ASN',
                'text' => '<p>Isi peraturan</p>',
                'file' => UploadedFile::fake()->create('peraturan.pdf', 10, 'application/pdf'),
            ], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Tambah Data Berhasil',
            ]);

        $legalProduct = LegalProduct::query()->firstOrFail();
        $this->assertSame('peraturan-asn', $legalProduct->slug);
        $this->assertSame($user->id, $legalProduct->user_id);
        $this->assertSame(0, $legalProduct->count_view);
        Storage::disk('public')->assertExists('upload/legal_product/'.$legalProduct->file);
    }

    public function test_validation_rejects_a_non_pdf_file(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->postJson('/legal_product/validate/Simpan', [
                'title' => 'Peraturan ASN',
                'text' => 'Isi peraturan',
                'file' => UploadedFile::fake()->create('peraturan.txt', 10, 'text/plain'),
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['file']);
    }

    public function test_list_returns_legal_products_for_datatables(): void
    {
        $legalProduct = LegalProduct::create([
            'title' => 'Peraturan ASN',
            'slug' => 'peraturan-asn',
            'text' => 'Isi peraturan',
            'file' => null,
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->getJson('/legal_product/list', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.0.id', $legalProduct->id)
            ->assertJsonPath('data.0.title', 'Peraturan ASN')
            ->assertJsonPath('data.0.user', $legalProduct->user->name);
    }

    public function test_edit_returns_the_requested_legal_product(): void
    {
        $legalProduct = LegalProduct::create([
            'title' => 'Peraturan ASN',
            'slug' => 'peraturan-asn',
            'text' => 'Isi peraturan',
            'file' => null,
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->getJson('/legal_product/edit/'.$legalProduct->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.id', $legalProduct->id)
            ->assertJsonPath('data.title', 'Peraturan ASN');
    }

    public function test_update_replaces_the_pdf_and_updates_the_slug(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/legal_product/old.pdf', '%PDF-1.4 old');
        $legalProduct = LegalProduct::create([
            'title' => 'Peraturan Lama',
            'slug' => 'peraturan-lama',
            'text' => 'Isi lama',
            'file' => 'old.pdf',
            'count_view' => 3,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->put('/legal_product/edit/'.$legalProduct->id, [
                'title' => 'Peraturan Baru',
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

        $this->assertDatabaseHas('legal_products', [
            'id' => $legalProduct->id,
            'title' => 'Peraturan Baru',
            'slug' => 'peraturan-baru',
            'text' => 'Isi baru',
            'count_view' => 3,
        ]);
        Storage::disk('public')->assertMissing('upload/legal_product/old.pdf');
        Storage::disk('public')->assertExists('upload/legal_product/'.$legalProduct->fresh()->file);
    }

    public function test_delete_removes_the_legal_product_and_its_pdf(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/legal_product/peraturan.pdf', '%PDF-1.4');
        $legalProduct = LegalProduct::create([
            'title' => 'Peraturan ASN',
            'slug' => 'peraturan-asn',
            'text' => 'Isi peraturan',
            'file' => 'peraturan.pdf',
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->getJson('/legal_product/delete/'.$legalProduct->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Hapus Data Berhasil',
            ]);

        $this->assertDatabaseMissing('legal_products', ['id' => $legalProduct->id]);
        Storage::disk('public')->assertMissing('upload/legal_product/peraturan.pdf');
    }

    public function test_ckeditor_image_upload_stores_an_image_and_returns_its_url(): void
    {
        Storage::fake('public');

        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->post('/legal_product/upload_image', [
                'CKEditorFuncNum' => 1,
                'upload' => UploadedFile::fake()->image('isi.png'),
            ]);

        $response->assertOk()
            ->assertSee('callFunction(1', false)
            ->assertSee('Upload berhasil', false);

        $files = Storage::disk('public')->allFiles('upload/legal_product/content');
        $this->assertCount(1, $files);
    }

    public function test_download_increments_the_view_count(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('upload/legal_product/peraturan.pdf', '%PDF-1.4');
        $legalProduct = LegalProduct::create([
            'title' => 'Peraturan ASN',
            'slug' => 'peraturan-asn',
            'text' => 'Isi peraturan',
            'file' => 'peraturan.pdf',
            'count_view' => null,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get('/legal_product/'.$legalProduct->id.'/download')
            ->assertOk();

        $this->assertDatabaseHas('legal_products', [
            'id' => $legalProduct->id,
            'count_view' => 1,
        ]);
    }

    public function test_public_page_lists_products_with_escaped_titles(): void
    {
        $title = 'Dokumen <script>alert(1)</script>';
        LegalProduct::create([
            'title' => $title,
            'slug' => 'dokumen',
            'text' => '<p>Ringkasan dokumen</p>',
            'file' => null,
            'count_view' => 0,
            'user_id' => User::factory()->create()->id,
        ]);

        $this->get('/info-produkhukum')
            ->assertOk()
            ->assertSee(e($title), false)
            ->assertDontSee($title, false)
            ->assertSee('Ringkasan dokumen');
    }
}
