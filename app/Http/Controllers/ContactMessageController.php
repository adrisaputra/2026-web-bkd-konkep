<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'identifier' => ['nullable', 'string', 'max:50'],
            'contact' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if (! is_string($value)) {
                        $fail('Masukkan alamat email atau nomor WhatsApp yang valid.');

                        return;
                    }

                    $isEmail = filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                    $isPhone = preg_match('/^\+?[0-9\s().-]{8,20}$/D', $value) === 1
                        && preg_match_all('/[0-9]/', $value) >= 8
                        && preg_match_all('/[0-9]/', $value) <= 15;

                    if (! $isEmail && ! $isPhone) {
                        $fail('Masukkan alamat email atau nomor WhatsApp yang valid.');
                    }
                },
            ],
            'category' => ['required', 'string', Rule::in(['promotion', 'retirement', 'leave', 'transfer', 'complaint'])],
            'message' => ['required', 'string', 'max:10000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'contact.required' => 'Email atau nomor WhatsApp wajib diisi.',
            'category.required' => 'Kategori layanan wajib dipilih.',
            'category.in' => 'Kategori layanan yang dipilih tidak valid.',
            'message.required' => 'Pesan atau pengaduan wajib diisi.',
            'message.max' => 'Pesan atau pengaduan maksimal 10.000 karakter.',
        ]);

        ContactMessage::create($validated);

        return back()->with('contact_status', 'Pesan atau pengaduan Anda berhasil dikirim ke BKD Konawe Kepulauan.');
    }
}
