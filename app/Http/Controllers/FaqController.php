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
                            <i class="fa fa-edit text-success"></i>
                        </a>';
                $button .= '<a href="#" onclick="deleteData('.$id.')" class="ms-3" title="Hapus">
                            <i class="fa fa-trash text-danger"></i>
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
