<?php

namespace Tests\Feature;

use App\Http\Middleware\RoleMiddleware;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_is_saved_and_confirms_success(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'identifier' => '1987654321',
            'contact' => '+62 821-1234-5678',
            'category' => 'complaint',
            'message' => 'Mohon informasi perkembangan pengaduan saya.',
        ];

        $this->from('/contact')
            ->post(route('contact-messages.store'), $payload)
            ->assertRedirect('/contact')
            ->assertSessionHas('contact_status', 'Pesan atau pengaduan Anda berhasil dikirim ke BKD Konawe Kepulauan.');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'identifier' => '1987654321',
            'contact' => '+62 821-1234-5678',
            'category' => 'complaint',
            'message' => 'Mohon informasi perkembangan pengaduan saya.',
        ]);
    }

    public function test_contact_form_accepts_a_valid_email_address(): void
    {
        $this->from('/contact')
            ->post(route('contact-messages.store'), [
                'name' => 'Ani Putri',
                'contact' => 'ani@example.com',
                'category' => 'leave',
                'message' => 'Saya ingin bertanya mengenai layanan cuti.',
            ])
            ->assertRedirect('/contact');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Ani Putri',
            'contact' => 'ani@example.com',
            'category' => 'leave',
        ]);
    }

    public function test_contact_form_rejects_an_invalid_contact_and_does_not_save(): void
    {
        $this->from('/contact')
            ->post(route('contact-messages.store'), [
                'name' => 'Budi Santoso',
                'contact' => 'alamat tidak valid',
                'category' => 'complaint',
                'message' => 'Mohon bantuan.',
            ])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors([
                'contact' => 'Masukkan alamat email atau nomor WhatsApp yang valid.',
            ]);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_form_rejects_a_non_string_contact_without_saving(): void
    {
        $this->from('/contact')
            ->post(route('contact-messages.store'), [
                'name' => 'Budi Santoso',
                'contact' => ['budi@example.com'],
                'category' => 'complaint',
                'message' => 'Mohon bantuan.',
            ])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors('contact');

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_contact_page_renders_a_csrf_protected_submission_form(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('action="'.route('contact-messages.store').'"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="name"', false)
            ->assertSee('name="contact"', false)
            ->assertSee('name="category"', false)
            ->assertSee('name="message"', false);
    }

    public function test_guest_is_redirected_from_the_admin_page(): void
    {
        $this->get('/contact-message')
            ->assertRedirect('/');
    }

    public function test_admin_page_lists_contact_messages_for_datatables(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Budi Santoso',
            'identifier' => '1987654321',
            'contact' => 'budi@example.com',
            'category' => 'complaint',
            'message' => 'Mohon bantuan.',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->getJson('/contact-message/list', ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.0.id', $contactMessage->id)
            ->assertJsonPath('data.0.name', 'Budi Santoso')
            ->assertJsonPath('data.0.category_label', 'Pengaduan / Lainnya');
    }

    public function test_admin_can_view_a_contact_message(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Budi Santoso',
            'identifier' => '1987654321',
            'contact' => 'budi@example.com',
            'category' => 'complaint',
            'message' => 'Mohon bantuan.',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->getJson('/contact-message/show/'.$contactMessage->id, ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('data.id', $contactMessage->id)
            ->assertJsonPath('data.identifier', '1987654321')
            ->assertJsonPath('data.message', 'Mohon bantuan.');
    }

    public function test_admin_can_delete_a_contact_message(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Budi Santoso',
            'contact' => 'budi@example.com',
            'category' => 'complaint',
            'message' => 'Mohon bantuan.',
        ]);

        $this->withoutMiddleware(RoleMiddleware::class)
            ->actingAs(User::factory()->create())
            ->deleteJson('/contact-message/delete/'.$contactMessage->id, [], ['X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Hapus Pesan Berhasil',
            ]);

        $this->assertDatabaseMissing('contact_messages', ['id' => $contactMessage->id]);
    }
}
