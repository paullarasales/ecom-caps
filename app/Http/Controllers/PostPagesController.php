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
    public function ownerpost()
    {
        return view('owner.post');
    }
    public function managerpost()
    {
        return view('manager.post');
    }
    public function add()
    {
        return view('admin.post-add');
    }
    public function owneradd()
    {
        return view('owner.post-add');
    }
    public function manageradd()
    {
        return view('manager.post-add');
    }
    public function view()
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.post-view', compact('post'));
    }
    public function ownerview()
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.post-view', compact('post'));
    }
    public function managerview()
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.post-view', compact('post'));
    }
}
