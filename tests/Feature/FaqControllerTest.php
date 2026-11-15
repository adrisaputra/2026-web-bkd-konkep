<?php

namespace Tests\Feature;

use App\Http\Middleware\RoleMiddleware;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_the_admin_page(): void
    {
        $this->get('/faq')
            ->assertRedirect('/');
    }

    public function test_store_creates_a_faq(): void
    {
        $response = $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->postJson('/faq/store', [
                'question' => 'Bagaimana mengajukan cuti?',
                'answer' => 'Ajukan melalui unit kerja.',
            ], ['X-Requested-With' => 'XMLHttpRequest']);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Tambah Data Berhasil',
            ]);

        $this->assertDatabaseHas('faqs', [
            'question' => 'Bagaimana mengajukan cuti?',
            'answer' => 'Ajukan melalui unit kerja.',
        ]);
    }

    public function test_validation_rejects_missing_question_and_answer(): void
    {
        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->postJson('/faq/validate/Simpan', [], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['question', 'answer']);
    }

    public function test_list_returns_faq_rows_for_datatables(): void
    {
        $faq = Faq::create([
            'question' => 'Bagaimana mengajukan cuti?',
            'answer' => 'Ajukan melalui unit kerja.',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->getJson('/faq/list', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.0.id', $faq->id)
            ->assertJsonPath('data.0.question', 'Bagaimana mengajukan cuti?')
            ->assertJsonPath('data.0.answer', 'Ajukan melalui unit kerja.');
    }

    public function test_edit_returns_the_requested_faq(): void
    {
        $faq = Faq::create([
            'question' => 'Bagaimana mengajukan cuti?',
            'answer' => 'Ajukan melalui unit kerja.',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->getJson('/faq/edit/'.$faq->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.id', $faq->id)
            ->assertJsonPath('data.question', 'Bagaimana mengajukan cuti?');
    }

    public function test_update_persists_the_faq_changes(): void
    {
        $faq = Faq::create([
            'question' => 'Pertanyaan lama',
            'answer' => 'Jawaban lama',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->putJson('/faq/edit/'.$faq->id, [
                'question' => 'Pertanyaan baru',
                'answer' => 'Jawaban baru',
            ], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Ubah Data Berhasil',
            ]);

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Pertanyaan baru',
            'answer' => 'Jawaban baru',
        ]);
    }

    public function test_delete_removes_the_faq(): void
    {
        $faq = Faq::create([
            'question' => 'Pertanyaan',
            'answer' => 'Jawaban',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->getJson('/faq/delete/'.$faq->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Hapus Data Berhasil',
            ]);

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_public_page_shows_faqs_and_escapes_user_content(): void
    {
        $question = 'Pertanyaan <script>alert(1)</script>';
        $faq = Faq::create([
            'question' => $question,
            'answer' => 'Jawaban yang ditampilkan.',
        ]);

        $this->get('/info-faq')
            ->assertOk()
            ->assertViewIs('pages.info-faq')
            ->assertViewHas('faqs', fn ($faqs) => $faqs->contains('id', $faq->id))
            ->assertSee(e($question), false)
            ->assertDontSee($question, false)
            ->assertSee('Jawaban yang ditampilkan.');
    }
}
