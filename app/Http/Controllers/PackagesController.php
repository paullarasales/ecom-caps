<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackagesController extends Controller
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
        $request->validate([
            'packagephoto' => 'required|image|mimes:png,jpg,jpeg,webp',
            'packagename' => 'required',
            'packagedesc' => 'required',
        ]);

        if ($file = $request->file('packagephoto')) {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filename
        
            $path = "uploads/package/";
            $file->move(public_path($path), $filename); // Move the file to the public directory
        
            $package = new Package();
            $package->packagename = $request->packagename;
            $package->packagedesc = $request->packagedesc;
            $package->user_id = Auth::id();
            $package->packagephoto = $path . $filename; // Save the image path
            $package->save();

            return redirect()->route('addpackage')->with('alert', 'Uploaded successfully!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $pk)
    {
        $package = Package::find($pk);
        return view('admin.packages-see')->with("package", $package);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $package)
    {
        $package = Package::find($package);
        return view('admin.packages-edit')->with("package", $package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'packagephoto' => 'nullable|image|mimes:png,jpg,jpeg,webp',
            'packagename' => 'required',
            'packagedesc' => 'required',
        ]);
    
        // Find the package by ID
        $package = Package::findOrFail($id);
    
        if ($file = $request->file('packagephoto')) {
            // Check if the package already has a photo and delete it
            if ($package->packagephoto && file_exists(public_path($package->packagephoto))) {
                unlink(public_path($package->packagephoto)); // Delete the old photo
            }
    
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filename
        
            $path = "uploads/package/";
            $file->move(public_path($path), $filename); // Move the file to the public directory
        
            // Update the photo path if a new file is uploaded
            $package->packagephoto = $path . $filename;
        }
    
        // Update the other fields
        $package->packagename = $request->packagename;
        $package->packagedesc = $request->packagedesc;
        $package->user_id = Auth::id();
    
        // Save the changes
        $package->save();
    
        return redirect()->route('viewpackage')->with('alert', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

    // Check if the package has a photo and delete it
    if ($package->packagephoto && file_exists(public_path($package->packagephoto))) {
        unlink(public_path($package->packagephoto)); // Delete the photo from the server
    }

    // Delete the package from the database
    $package->delete();

    return redirect()->route('viewpackage')->with('alert', 'Package deleted successfully!');
    }
    
}
