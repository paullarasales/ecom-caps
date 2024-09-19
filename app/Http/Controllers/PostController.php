<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'images.*' => 'required|image|mimes:png,jpg,jpeg,webp',
            'description' => 'required',
        ]);
        
        $imageData = [];
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filenames
    
                $path = "uploads/post/";
                $file->move(public_path($path), $filename); // Move the file to the public directory
    
                $imageData[] = $path . $filename; // Collect image paths
            }
        }
    
        $post = new Post();
        $post->postdesc = $request->description;
        $post->user_id = Auth::id();
        $post->postimage = $imageData; // Save all image paths as an array
        $post->save();
    
        return redirect()->route('adminpost')->with('alert', 'Uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $post_id)
    {
        $post = Post::find($post_id);
        return view('admin.post-edit')->with("post", $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
    $request->validate([
        'images.*' => 'image|mimes:png,jpg,jpeg,webp',
        'description' => 'required',
    ]);

    // Find the existing post
    $post = Post::findOrFail($id);

    // Delete existing images from storage
    if (!empty($post->postimage)) {
        foreach ($post->postimage as $image) {
            if (file_exists(public_path($image))) {
                unlink(public_path($image)); // Delete the file
            }
        }
    }

    // Initialize an array to store new image paths
    $imageData = [];

    // Handle new image uploads
    if ($files = $request->file('images')) {
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filenames

            $path = "uploads/post/";
            $file->move(public_path($path), $filename); // Move the file to the public directory

            $imageData[] = $path . $filename; // Collect new image paths
        }
    }

    // Update the post with new data
    $post->postdesc = $request->description;
    $post->user_id = Auth::id();
    $post->postimage = $imageData; // Update the image paths with new ones
    $post->save();

    return redirect()->route('viewpost')->with('alert', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $post_id)
    {
        $post = Post::findOrFail($post_id);

        // Check if the post has images and delete each one
        if (!empty($post->postimage)) {
            foreach ($post->postimage as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image)); // Delete the image from the server
                }
            }
        }

        // Delete the post from the database
        $post->delete();

        return redirect()->route('viewpost')->with('alert', 'Post deleted successfully!');
    }
}
