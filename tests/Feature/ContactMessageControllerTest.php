<?php

namespace Tests\Feature;

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
}
