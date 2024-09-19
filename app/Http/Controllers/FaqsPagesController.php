<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;

class FaqsPagesController extends Controller
{
    public function faqs()
    {
        return view('admin.faqs');
    }
    public function add()
    {
        return view('admin.faqs-add');
    }
    public function view()
    {
        $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.faqs-view', compact('faqs'));
    }
}
