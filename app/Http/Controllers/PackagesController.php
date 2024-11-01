<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Custom;
use App\Models\Appointment;
use App\Models\Food;
use App\Models\Foodcart;
use App\Models\Foodpack;
use App\Models\Customitem;
use App\Models\Custompackage;

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

            // return redirect()->route('addpackage')->with('alert', 'Uploaded successfully!');
            if (Auth::check()) {
                $user = Auth::user();
            
                if ($user->usertype === 'admin') {
                    return redirect()->route('addpackage')->with('alert', 'Package added successfully!');
                } elseif ($user->usertype === 'manager') {
                    return redirect()->route('manageraddpackage')->with('alert', 'Package added successfully!');
                }
            }
        }

    }

    public function custom(Request $request)
    {
        $request->validate([
            'veggie' => 'integer|min:0',
            'chicken' => 'integer|min:0',
            'fish' => 'integer|min:0',
            'pork' => 'integer|min:0',
            'beef' => 'integer|min:0',
            'persons' => 'required|integer|min:1',
            'final' => 'required|nullable|numeric',
            'setup' => 'string|in:Yes,No',
            'lootbags' => 'integer|min:0',
            'foodpack' => 'integer|min:0',
            'lechonQuantity' => 'integer|min:0',
            
        ]);

            $package = new Package();
            $package->user_id = Auth::id();
            $package->packagename = 'Custom'; 
            $package->packagedesc = $request->input('final'); 
            $package->packagephoto = 'images/custom.jpg'; 
            $package->save();
        
            // Store data into the database
            $custom = new Custom();
            $custom->user_id = Auth::id();
            $custom->package_id = $package->package_id;

            $custom->veggie = $request->input('veggie');
            $custom->chicken = $request->input('chicken');
            $custom->fish = $request->input('fish');
            $custom->pork = $request->input('pork');
            $custom->beef = $request->input('beef');

            $custom->foodpack = $request->input('foodpack');
            $custom->packname = $request->input('packname');
            $custom->lechonname = $request->input('lechonkg');
            $custom->lechon = $request->input('lechonQuantity');

            $custom->icecream = $request->has('IceCream');
            $custom->frenchfries = $request->has('FrenchFries');
            $custom->mixedballs = $request->has('MixedBalls');
            $custom->hotdogs = $request->has('Hotdogs');

            $custom->cake = $request->has('Cake');
            $custom->lootbags = $request->input('Lootbags');
            $custom->setup = $request->input('Setup');

            $custom->persons = $request->input('persons');
            $custom->final = $request->input('final');
            $custom->save();

            return redirect()->back()->with('alert', 'Custom package created successfully.');

    }
    public function managercustom(Request $request)
    {
        $request->validate([
            'veggie' => 'integer|min:0',
            'chicken' => 'integer|min:0',
            'fish' => 'integer|min:0',
            'pork' => 'integer|min:0',
            'beef' => 'integer|min:0',
            'persons' => 'required|integer|min:1',
            'final' => 'required|nullable|numeric',
            'setup' => 'string|in:Yes,No',
            'lootbags' => 'integer|min:0',
            'foodpack' => 'integer|min:0',
            'lechonQuantity' => 'integer|min:0',
            
        ]);

            $package = new Package();
            $package->user_id = Auth::id();
            $package->packagename = 'Custom'; 
            $package->packagedesc = $request->input('final'); 
            $package->packagephoto = 'images/custom.jpg'; 
            $package->save();
        
            // Store data into the database
            $custom = new Custom();
            $custom->user_id = Auth::id();
            $custom->package_id = $package->package_id;
            $custom->veggie = $request->input('veggie');
            $custom->chicken = $request->input('chicken');
            $custom->pork = $request->input('pork');
            $custom->beef = $request->input('beef');

            $custom->foodpack = $request->input('foodpack');
            $custom->packname = $request->input('packname');
            $custom->lechonname = $request->input('lechonkg');
            $custom->lechon = $request->input('lechonQuantity');

            $custom->icecream = $request->has('IceCream');
            $custom->frenchfries = $request->has('FrenchFries');
            $custom->mixedballs = $request->has('MixedBalls');
            $custom->hotdogs = $request->has('Hotdogs');

            $custom->cake = $request->has('Cake');
            $custom->lootbags = $request->input('Lootbags');
            $custom->setup = $request->input('Setup');
            
            $custom->persons = $request->input('persons');
            $custom->final = $request->input('final');
            $custom->save();

            return redirect()->back()->with('alert', 'Custom package created successfully.');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $pk)
{
    // Find the Package by its primary key (pk)
    $package = Package::findOrFail($pk);

    // Retrieve the associated Custompackage, loading its related Customitems
    $customPackage = Custompackage::with('items') // This will load the related items
                                  ->where('package_id', $package->package_id)
                                  ->first(); // Ensure you're getting a single instance

    // Pass both the package and the custom package (with items) to the view
    return view('admin.packages-see')->with([
        'package' => $package,
        'customPackage' => $customPackage,
    ]);
}


    // $package = Package::find($pk);
        // $custom = Custom::where('package_id', $package->package_id)->first();
        // // return view('admin.packages-see')->with("package", $package);
        // return view('admin.packages-see')->with([
        //     'package' => $package,
        //     'custom' => $custom,
        // ]);
    public function managershow(string $pk)
    {
        $package = Package::find($pk);
        $custom = Custom::where('package_id', $package->package_id)->first();
        // return view('admin.packages-see')->with("package", $package);
        return view('manager.packages-see')->with([
            'package' => $package,
            'custom' => $custom,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $package)
    {
        $package = Package::find($package);
        return view('admin.packages-edit')->with("package", $package);
    }
    public function manageredit(string $package)
    {
        $package = Package::find($package);
        return view('manager.packages-edit')->with("package", $package);
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
    public function managerupdate(Request $request, string $id)
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
    
        return redirect()->route('managerviewpackage')->with('alert', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any existing appointment
        $appointment = Appointment::where('package_id', $package->package_id)->first();

        // If an appointment is tied to this package, prevent deletion
        if ($appointment) {
            return redirect()->route('viewpackage')->with('alert', 'Cannot delete package as it is tied to an existing appointment.');
        }

        // Check if there is a corresponding custom entry
        $custom = Custom::where('package_id', $package->package_id)->first();

        // If a custom entry exists, delete it
        if ($custom) {
            $custom->delete();
        }

        // Check if the package has a photo and delete it
        if ($package->packagephoto && file_exists(public_path($package->packagephoto)) && $package->packagename !== 'Custom') {
            unlink(public_path($package->packagephoto)); // Delete the photo from the server
        }

        // Delete the package from the database
        $package->delete();

        return redirect()->route('viewpackage')->with('alert', 'Package deleted successfully!');
    }

    public function managerdestroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any existing appointment
        $appointment = Appointment::where('package_id', $package->package_id)->first();

        // If an appointment is tied to this package, prevent deletion
        if ($appointment) {
            return redirect()->route('viewpackage')->with('alert', 'Cannot delete package as it is tied to an existing appointment.');
        }

        // Check if there is a corresponding custom entry
        $custom = Custom::where('package_id', $package->package_id)->first();

        // If a custom entry exists, delete it
        if ($custom) {
            $custom->delete();
        }

        // Check if the package has a photo and delete it
        if ($package->packagephoto && file_exists(public_path($package->packagephoto)) && $package->packagename !== 'Custom') {
            unlink(public_path($package->packagephoto)); // Delete the photo from the server
        }

        // Delete the package from the database
        $package->delete();

        return redirect()->route('managerviewpackage')->with('alert', 'Package deleted successfully!');
    }
    
}
