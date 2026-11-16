<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    // # Show Data
    public function index(): View
    {
        $title = 'FAQ';

        return view('admin.faq.index', compact('title'));
    }

    // # Get Data
    public function get_faq_index(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $counter = 1;
        $faqs = Faq::query();

        return DataTables::of($faqs)
            ->addIndexColumn()
            ->addColumn('number', function () use (&$counter) {
                return $counter++;
            })
            ->addColumn('action', function (Faq $faq) {
                $id = (int) $faq->id;

                $button = '<a href="#" onClick="getData('.$id.')" data-bs-toggle="modal" data-bs-target="#kt_modal_add_faq" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                        </a>';
                $button .= '<a href="#" onclick="deleteData('.$id.')" class="ms-3" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function validate(Request $request, string $action): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ], [], [
            'question' => 'Pertanyaan',
            'answer' => 'Jawaban',
        ]);

        return response()->json(['success' => true]);
    }

    // # Save Data
    public function store(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $validated = $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ], [], [
            'question' => 'Pertanyaan',
            'answer' => 'Jawaban',
        ]);

        Faq::create($validated);

        activity()->log('Create Data FAQ');

        return response()->json(['success' => true, 'message' => 'Tambah Data Berhasil']);
    }

    // # Get Data
    public function edit(Request $request, int $id): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $faq = Faq::findOrFail($id);

        return response()->json(['success' => true, 'data' => $faq]);
    }

    // # Edit Data
    public function update(Request $request, Faq $faq): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $validated = $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ], [], [
            'question' => 'Pertanyaan',
            'answer' => 'Jawaban',
        ]);

        $faq->update($validated);

        activity()->log('Edit Data FAQ With ID = '.$faq->id);

        return response()->json(['success' => true, 'message' => 'Ubah Data Berhasil']);
    }

    // # Delete Data
    public function delete(Request $request, Faq $faq): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $faq->delete();

        activity()->log('Delete Data FAQ With ID = '.$faq->id);

        return response()->json(['success' => true, 'message' => 'Hapus Data Berhasil']);
    }
}
