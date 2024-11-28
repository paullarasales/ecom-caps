<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Log as ModelsLog;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NewSampleController extends Controller
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
        Log::info('Store method called.');

        $request->validate([
            'package_id' => 'required|exists:packages,package_id',
            'sampleimages.*' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        Log::info('Validation passed.');

        $imageData = [];
        if ($files = $request->file('sampleimages')) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filenames
    
                $path = "uploads/sample/";
                $file->move(public_path($path), $filename); // Move the file to the public directory
    
                $imageData[] = $path . $filename; // Collect image paths
            }
        }

        Log::info('Files processed.', ['images' => $imageData]);

        $sample = new Sample();
        $sample->package_id = $request->package_id;
        $sample->samplepath = $imageData; // Save all image paths as an array
        $sample->save();

        Log::info('Sample saved.', ['sample' => $sample]);

        $user = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Added Sample Photos';
            $log->description = $user->firstname . " " . $user->lastname . " added sample photos to a package";
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('alert', 'Uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
