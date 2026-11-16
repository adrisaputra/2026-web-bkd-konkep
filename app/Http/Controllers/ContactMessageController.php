<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $title = 'Pesan Kontak';

        return view('admin.contact_message.index', compact('title'));
    }

    public function get_contact_message_index(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $counter = 1;
        $contactMessages = ContactMessage::query()->latest('created_at');

        return DataTables::of($contactMessages)
            ->addIndexColumn()
            ->addColumn('number', function () use (&$counter) {
                return $counter++;
            })
            ->addColumn('category_label', function (ContactMessage $contactMessage): string {
                return $this->categoryLabel($contactMessage);
            })
            ->addColumn('received_at', function (ContactMessage $contactMessage): string {
                return $contactMessage->created_at->format('d-m-Y H:i');
            })
            ->addColumn('action', function (ContactMessage $contactMessage): string {
                $id = (int) $contactMessage->id;

                return '<a href="#" onclick="viewData('.$id.')" data-bs-toggle="modal" data-bs-target="#kt_modal_view_contact_message" title="Lihat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="#" onclick="deleteData('.$id.')" class="ms-3" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(Request $request, ContactMessage $contactMessage): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $data = $contactMessage->toArray();
        $data['category_label'] = $this->categoryLabel($contactMessage);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function delete(Request $request, ContactMessage $contactMessage): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $contactMessage->delete();

        activity()->log('Delete Data Contact Message With ID = '.$contactMessage->id);

        return response()->json(['success' => true, 'message' => 'Hapus Pesan Berhasil']);
    }

    private function categoryLabel(ContactMessage $contactMessage): string
    {
        return match ($contactMessage->category) {
            'promotion' => 'Kenaikan Pangkat',
            'retirement' => 'Pensiun',
            'leave' => 'Cuti & Izin',
            'transfer' => 'Mutasi / Pindah Tugas',
            'complaint' => 'Pengaduan / Lainnya',
            default => $contactMessage->category,
        };
    }

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
