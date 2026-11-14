<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;

class HomeController extends Controller
{
    // # Show Data
    public function index()
    {
        $title = 'Dashboard';
        $news = News::count();
        $user = User::count();

        // $message = Message::orderBy('id','DESC')->limit('3')->get();
        return view('admin.home', compact('title', 'news', 'user'));
    }
}
