<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    // # Show Data
    public function index()
    {
        $title = 'Pengumuman';

        return view('admin.announcement.index', compact('title'));
    }

    // # Get Data
    public function get_announcement_index(Request $request)
    {

        if ($request->ajax()) {
            $counter = 1;

            $announcement = Announcement::limit(10);

            return DataTables::of($announcement)
                ->addIndexColumn()
                ->addColumn('number', function () use (&$counter) {
                    return $counter++;
                })
                ->addColumn('created_at', function ($v) {
                    return Helpers::month_indo_full($v->created_at);
                })
                ->addColumn('user', function ($v) {
                    return $v->user ? $v->user->name : '';
                })
                ->addColumn('action', function ($v) {
                    $btn = '<a href="#" onClick="getData('.$v->id.')" id="'.$v->id.'" data-toggle="tooltip" data-placement="top" title="Edit" data-bs-toggle="modal" data-bs-target="#kt_modal_add_announcement">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                        </a>';
                    $btn .= '<a href="#" onclick="deleteData('.$v->id.')" id="'.$v->id.'" class="warning confirm" data-toggle="tooltip" data-placement="top" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </a>';

                    return $btn;
                })
                ->rawColumns(['file', 'action'])->make(true);
        }
    }

    public function validate(Request $request, $action)
    {
        if ($request->ajax()) {

            $attributes = [
                'title' => 'Judul',
                'text' => 'Isi',
                'file' => 'File',
            ];

            if ($action === 'Simpan') {
                $rules = [
                    'title' => 'required',
                    'text' => 'required',
                    'file' => 'required|mimes:pdf',
                ];
            } else {
                $rules = [
                    'title' => 'required',
                    'text' => 'required',
                    'file' => 'mimes:pdf',
                ];
            }

            $request->validate($rules, [], $attributes);

            return response()->json(['success' => true]);
        }
    }

    // # Save Data
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $announcement = new Announcement;
            $announcement->fill($request->all());
            $announcement->slug = Str::slug($request->title);
            $announcement->user_id = Auth::user()->id;

            if ($request->file) {
                $announcement->file = time().'.'.$request->file->getClientOriginalExtension();
                Storage::putFileAs('upload/announcement', $request->file('file'), $announcement->file);
            }

            $announcement->save();

            activity()->log('Create Data Announcement');

            return response()->json(['success' => true, 'message' => 'Tambah Data Berhasil']);
        }
    }

    // # Get Data
    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $announcement = Announcement::where('id', $id)->first();

            return response()->json(['success' => true, 'data' => $announcement]);
        }
    }

    // # Edit Data
    public function update(Request $request, Announcement $announcement)
    {
        if ($request->ajax()) {
            $announcement->title = $request->title;
            $announcement->text = $request->text;
            $announcement->slug = Str::slug($request->title);

            if ($announcement->file && $request->file('file') != '') {
                Storage::delete('upload/announcement/'.$announcement->file);
            }

            if ($request->file('file')) {
                $announcement->file = time().'.'.$request->file->getClientOriginalExtension();
                Storage::putFileAs('upload/announcement', $request->file('file'), $announcement->file);
            }

            $announcement->save();

            activity()->log('Edit Data Announcement With ID = '.$announcement->id);

            return response()->json(['success' => true, 'message' => 'Ubah Data Berhasil']);
        }
    }

    // # Delete Data
    public function delete(Request $request, Announcement $announcement)
    {
        if ($request->ajax()) {
            $file = $announcement->file;
            $announcement->delete();

            if ($file) {
                Storage::delete('upload/announcement/'.$file);
            }

            activity()->log('Delete Data Announcement With ID = '.$announcement->id);

            return response()->json(['success' => true, 'message' => 'Hapus Data Berhasil']);
        }
    }
}
