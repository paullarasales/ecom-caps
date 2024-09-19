<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;

class AdminController extends Controller
{
    public function chat()
    {
        $users = User::all();
        return view('admin.chat', compact('users'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    public function others()
    {
        return view('admin.others');
    }
    public function admindashboard()
    {
        return view('admin.dashboard');
    }
    public function appointments()
    {
        return view('admin.appointments');
    }
    public function packages()
    {
        return view('admin.packages');
    }
    public function adminreviews()
    {
        return view('admin.reviews');
    }
    public function users()
    {
        return view('admin.users');
    }
}
