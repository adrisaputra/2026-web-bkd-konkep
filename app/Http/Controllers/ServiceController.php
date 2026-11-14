<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    // # Show Data
    public function index(Request $request): View
    {
        $service = Service::where('menu', $request->segment(2))->firstOrFail();
        $title = $service->title;

        return view('admin.service.index', compact('title', 'service'));
    }

    public function validation(Request $request): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $request->validate([
            'text' => 'required|string',
            'condition' => 'nullable|string',
            'url' => 'nullable|string|max:255',
        ]);

        return response()->json(['success' => true]);
    }

    // # Edit Data
    public function update(Request $request, Service $service): JsonResponse
    {
        abort_unless($request->ajax(), 404);

        $validated = $request->validate([
            'text' => 'required|string',
            'condition' => 'nullable|string',
            'url' => 'nullable|string|max:255',
        ]);

        $service->text = $validated['text'];
        $service->condition = $validated['condition'] ?? null;
        $service->url = $validated['url'] ?? null;
        $service->save();

        activity()->log('Edit Data Service With ID = '.$service->id);

        return response()->json(['success' => true, 'message' => 'Ubah Data Berhasil']);
    }
}
