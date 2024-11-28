<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Log as ModelsLog;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function add($package_id)
    {
        return view('admin.sample-add', compact('package_id'));
    }
    public function addmanager($package_id)
    {
        return view('manager.sample-add', compact('package_id'));
    }
    public function addowner($package_id)
    {
        return view('owner.sample-add', compact('package_id'));
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

        $request->validate([
            'package_id' => 'required|exists:packages,package_id',
            'sampleimages.*' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);


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


        $sample = new Sample();
        $sample->package_id = $request->package_id;
        $sample->samplepath = $imageData; // Save all image paths as an array
        $sample->save();


        $user = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Added Sample Photos';
            $log->description = $user->firstname . " " . $user->lastname . " added sample photos to a package";
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Uploaded successfully!');
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
    public function edit(string $sample_id)
    {
        $sample = Sample::findOrFail($sample_id);
        return view('admin.sample-edit', compact('sample'));
    }
    public function editmanager(string $sample_id)
    {
        $sample = Sample::findOrFail($sample_id);
        return view('manager.sample-edit', compact('sample'));
    }
    public function editowner(string $sample_id)
    {
        $sample = Sample::findOrFail($sample_id);
        return view('owner.sample-edit', compact('sample'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $sample_id)
    {
        $request->validate([
            'sample_id' => 'required|exists:samples,sample_id',
            'sampleimages.*' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        $sample = Sample::findOrFail($sample_id);

        if (!empty($sample->samplepath)) {
            foreach ($sample->samplepath as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

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

        // Update the post with new data
        $sample->samplepath = $imageData; // Update the image paths with new ones
        $sample->save();

        $user = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Updated Sample Photos';
            $log->description = $user->firstname . " " . $user->lastname . " added sample photos to a package";
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function updatemanager(Request $request, string $sample_id)
    {
        $request->validate([
            'sample_id' => 'required|exists:samples,sample_id',
            'sampleimages.*' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        $sample = Sample::findOrFail($sample_id);

        if (!empty($sample->samplepath)) {
            foreach ($sample->samplepath as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

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

        // Update the post with new data
        $sample->samplepath = $imageData; // Update the image paths with new ones
        $sample->save();

        $user = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Updated Sample Photos';
            $log->description = $user->firstname . " " . $user->lastname . " added sample photos to a package";
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function updateowner(Request $request, string $sample_id)
    {
        $request->validate([
            'sample_id' => 'required|exists:samples,sample_id',
            'sampleimages.*' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        $sample = Sample::findOrFail($sample_id);

        if (!empty($sample->samplepath)) {
            foreach ($sample->samplepath as $image) {
                if (file_exists(public_path($image))) {
                    unlink(public_path($image));
                }
            }
        }

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

        // Update the post with new data
        $sample->samplepath = $imageData; // Update the image paths with new ones
        $sample->save();

        $user = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Updated Sample Photos';
            $log->description = $user->firstname . " " . $user->lastname . " added sample photos to a package";
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
