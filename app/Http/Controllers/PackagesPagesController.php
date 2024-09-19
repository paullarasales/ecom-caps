<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackagesPagesController extends Controller
{
    public function add()
    {
        return view('admin.packages-add');
    }
    public function customize()
    {
        return view('admin.packages-customize');
    }
    public function view()
    {
        // return view('admin.packages-view');
        $package = Package::orderBy('created_at', 'desc')->get();
        return view('admin.packages-view', compact('package'));
    }
    // public function eye()
    // {
    //     // return view('admin.packages-view');
    //     $package = Package::orderBy('created_at', 'desc')->get();
    //     return view('admin.packages-eye', compact('package'));
    // }
}
