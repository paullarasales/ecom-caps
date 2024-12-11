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
use App\Models\Log;
use Illuminate\Validation\Rule;


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
            'packagename' => 'required|unique:packages,packagename',
            'packageprice' => 'required|numeric',
            'package_inclusions' => 'required|array|min:1', // Validate that there is at least one inclusion
            'package_inclusions.*' => 'required|string', // Each inclusion should be a string
        ]);

        // Collect package inclusions and encode them as a JSON string
        $inclusions = json_encode($request->input('package_inclusions'));

        // Create a new package record
        $package = new Package();
        $package->packagename = $request->packagename;
        $package->packagedesc = $request->packageprice;  // Assuming package price is used as description, adjust as needed
        $package->user_id = Auth::id();
        $package->packageinclusion = $inclusions;  // Store inclusions in the database
        $package->packagetype = "Normal";  // Or adjust if dynamic
        $package->save();

        // Log the package creation action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Package Created';
        $log->description = $package->packagename . " package created by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Package added successfully!');
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
    public function show(string $package_id)
    {
        // Find the Package by its primary key (pk)
        $package = Package::findOrFail($package_id);

        // Retrieve the associated Custompackage, loading its related Customitems
        $customPackage = Custompackage::with('items') // This will load the related items
                                    ->where('package_id', $package->package_id)
                                    ->first(); // Ensure you're getting a single instance

        $samplePhotos = $package->sample ? $package->sample->samplepath : null;

        $appointmentCount = $package->appointment()->count();
        $appointments = $package->appointment()->latest()->first();


        // Pass both the package and the custom package (with items) to the view
        return view('admin.packages-see')->with([
            'package' => $package,
            'customPackage' => $customPackage,
            'samplePhotos' => $samplePhotos,
            'appointmentCount' => $appointmentCount,
            'appointments' => $appointments,
        ]);
    }


    public function managershow(string $package_id)
    {
        // Find the Package by its primary key (pk)
        $package = Package::findOrFail($package_id);

        // Retrieve the associated Custompackage, loading its related Customitems
        $customPackage = Custompackage::with('items') // This will load the related items
                                    ->where('package_id', $package->package_id)
                                    ->first(); // Ensure you're getting a single instance

        $samplePhotos = $package->sample ? $package->sample->samplepath : null;

        $appointmentCount = $package->appointment()->count();
        $appointments = $package->appointment()->latest()->first();


        // Pass both the package and the custom package (with items) to the view
        return view('manager.packages-see')->with([
            'package' => $package,
            'customPackage' => $customPackage,
            'samplePhotos' => $samplePhotos,
            'appointmentCount' => $appointmentCount,
            'appointments' => $appointments,
        ]);
    }

    public function ownershow(string $pk)
    {
        // Find the Package by its primary key (pk)
        $package = Package::findOrFail($pk);

        // Retrieve the associated Custompackage, loading its related Customitems
        $customPackage = Custompackage::with('items') // This will load the related items
                                    ->where('package_id', $package->package_id)
                                    ->first(); // Ensure you're getting a single instance

        $samplePhotos = $package->sample ? $package->sample->samplepath : null;

        $appointmentCount = $package->appointment()->count();
        $appointments = $package->appointment()->latest()->first();


        // Pass both the package and the custom package (with items) to the view
        return view('owner.packages-see')->with([
            'package' => $package,
            'customPackage' => $customPackage,
            'samplePhotos' => $samplePhotos,
            'appointmentCount' => $appointmentCount,
            'appointments' => $appointments,
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
    public function owneredit(string $package)
    {
        $package = Package::find($package);
        return view('owner.packages-edit')->with("package", $package);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'packagename' => [
                'required',
                Rule::unique('packages', 'packagename')->ignore($id, 'package_id'),
            ],
            'packageprice' => 'required|numeric',
            'package_inclusions' => 'required|array|min:1', // Validate that there is at least one inclusion
            'package_inclusions.*' => 'required|string', // Each inclusion should be a string
        ]);

        // Collect package inclusions and encode them as a JSON string
        $inclusions = json_encode($request->input('package_inclusions'));

        // Find the package by ID
        $package = Package::findOrFail($id);

        // Update the package fields
        $package->packagename = $request->packagename;
        $package->packagedesc = $request->packageprice;  // Assuming package price is used as description, adjust as needed
        $package->packageinclusion = $inclusions;  // Store inclusions in the database
        $package->user_id = Auth::id();

        // Save the changes
        $package->save();

        // Log the package update action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Package Updated';
        $log->description = $package->packagename . " package updated by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function managerupdate(Request $request, string $id)
    {
        $request->validate([
            'packagename' => [
                'required',
                Rule::unique('packages', 'packagename')->ignore($id, 'package_id'),
            ],
            'packageprice' => 'required|numeric',
            'package_inclusions' => 'required|array|min:1', // Validate that there is at least one inclusion
            'package_inclusions.*' => 'required|string', // Each inclusion should be a string
        ]);

        // Collect package inclusions and encode them as a JSON string
        $inclusions = json_encode($request->input('package_inclusions'));

        // Find the package by ID
        $package = Package::findOrFail($id);

        // Update the package fields
        $package->packagename = $request->packagename;
        $package->packagedesc = $request->packageprice;  // Assuming package price is used as description, adjust as needed
        $package->packageinclusion = $inclusions;  // Store inclusions in the database
        $package->user_id = Auth::id();

        // Save the changes
        $package->save();

        // Log the package update action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Package Updated';
        $log->description = $package->packagename . " package updated by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function ownerupdate(Request $request, string $id)
    {
        $request->validate([
            'packagename' => [
                'required',
                Rule::unique('packages', 'packagename')->ignore($id, 'package_id'),
            ],
            'packageprice' => 'required|numeric',
            'package_inclusions' => 'required|array|min:1', // Validate that there is at least one inclusion
            'package_inclusions.*' => 'required|string', // Each inclusion should be a string
        ]);

        // Collect package inclusions and encode them as a JSON string
        $inclusions = json_encode($request->input('package_inclusions'));

        // Find the package by ID
        $package = Package::findOrFail($id);

        // Update the package fields
        $package->packagename = $request->packagename;
        $package->packagedesc = $request->packageprice;  // Assuming package price is used as description, adjust as needed
        $package->packageinclusion = $inclusions;  // Store inclusions in the database
        $package->user_id = Auth::id();

        // Save the changes
        $package->save();

        // Log the package update action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Package Updated';
        $log->description = $package->packagename . " package updated by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();
    
            return redirect()->back()->with('success', 'Updated successfully!');
    }

    //ARCHIVE
    public function archive(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        $appointment = Appointment::where('package_id', $package->package_id)
        ->whereIn('status', ['pending', 'booked'])
        ->first();

        if ($appointment) {
            return redirect()->back()->with('error', 'Cannot archive package as it is tied to an existing appointment or event.');
        }

        // Update the other fields
        $package->packagestatus = "archived";
    
        // Save the changes
        $package->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Deleted';
            $log->description = $package->packagename . " package archived by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->back()->with('success', 'Package archived successfully!');
    }
    public function unarchive(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Update the other fields
        $package->packagestatus = "active";
    
        // Save the changes
        $package->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Deleted';
            $log->description = $package->packagename . " package unarchived by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->back()->with('success', 'Package archived successfully!');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any existing appointment
        $appointment = Appointment::where('package_id', $package->package_id)
        ->whereIn('status', ['pending', 'booked'])
        ->first();

        // If an appointment is tied to this package, prevent deletion
        if ($appointment) {
            return redirect()->route('viewpackage')->with('error', 'Cannot delete package as it is tied to an existing appointment.');
        }

        // Update any appointments with 'done' status to set package_id to null
        Appointment::where('package_id', $package_id)
        ->whereIn('status', ['done', 'cancelled', 'cancelled'])
        ->update(['package_id' => null]);

        // Check if there is a corresponding custom entry
        $custom = Custompackage::where('package_id', $package->package_id)->first();

        // If a custom entry exists, delete it
        if ($custom) {
            $custom->delete();
        }

        // Check if the package has a photo and delete it
        if ($package->packagephoto && file_exists(public_path($package->packagephoto)) && $package->packagetype !== 'Custom') {
            unlink(public_path($package->packagephoto)); // Delete the photo from the server
        }

        // Delete the package from the database
        $package->delete();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Deleted';
            $log->description = $package->packagename . " package deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('viewpackage')->with('success', 'Package deleted successfully!');
    }

    public function managerdestroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any existing appointment
        $appointment = Appointment::where('package_id', $package->package_id)
        ->whereIn('status', ['pending', 'booked'])
        ->first();

        // If an appointment is tied to this package, prevent deletion
        if ($appointment) {
            return redirect()->route('managerviewpackage')->with('error', 'Cannot delete package as it is tied to an existing appointment.');
        }

        // Update any appointments with 'done' status to set package_id to null
        Appointment::where('package_id', $package_id)
        ->whereIn('status', ['done', 'cancelled', 'cancelled'])
        ->update(['package_id' => null]);

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

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Deleted';
            $log->description = $package->packagename . " package deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('managerviewpackage')->with('success', 'Package deleted successfully!');
    }

    public function ownerdestroy(string $package_id)
    {
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any existing appointment
        $appointment = Appointment::where('package_id', $package->package_id)
        ->whereIn('status', ['pending', 'booked'])
        ->first();

        // If an appointment is tied to this package, prevent deletion
        if ($appointment) {
            return redirect()->route('ownerviewpackage')->with('error', 'Cannot delete package as it is tied to an existing appointment.');
        }

        // Update any appointments with 'done' status to set package_id to null
        Appointment::where('package_id', $package_id)
        ->whereIn('status', ['done', 'cancelled', 'cancelled'])
        ->update(['package_id' => null]);

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

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Deleted';
            $log->description = $package->packagename . " package deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('ownerviewpackage')->with('success', 'Package deleted successfully!');
    }
    
}
