<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostPagesController extends Controller
{
    public function post()
    {
        return view('admin.post');
    }
    public function add()
    {
        return view('admin.post-add');
    }
    public function view()
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.post-view', compact('post'));
    }
}
