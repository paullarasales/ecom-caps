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
    public function ownerfaqs()
    {
        return view('owner.faqs');
    }
    public function managerfaqs()
    {
        return view('manager.faqs');
    }
    public function add()
    {
        return view('admin.faqs-add');
    }
    public function owneradd()
    {
        return view('owner.faqs-add');
    }
    public function manageradd()
    {
        return view('manager.faqs-add');
    }
    public function view()
    {
        $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.faqs-view', compact('faqs'));
    }
    public function ownerview()
    {
        $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        return view('owner.faqs-view', compact('faqs'));
    }
    public function managerview()
    {
        $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        return view('manager.faqs-view', compact('faqs'));
    }
}
