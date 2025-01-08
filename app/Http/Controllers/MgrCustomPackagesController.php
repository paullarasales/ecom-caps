<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Foodcart;
use App\Models\Foodpack;
use App\Models\Facepaint;
use App\Models\Lechon;
use App\Models\Cake;
use App\Models\Clown;
use App\Models\Setup;
use Illuminate\Support\Facades\Auth;
use App\Models\Customitem;
use App\Models\Custompackage;
use App\Models\Package;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use App\Models\Log as ModelsLog;
use App\Models\Beef;
use App\Models\Pork;
use App\Models\Chicken;
use App\Models\Veggie;
use App\Models\Others;
use App\Models\Dessert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MgrCustomPackagesController extends Controller
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



    public function store(Request $request)
    {

        $request->validate([
            // 'package_id' => 'required|exists:packages,package_id',
            'final' => 'required|numeric',
            'packagename' => 'required',
            'foodpackitem' => 'required|array',
            'foodpackquantity' => 'required|array',
            'foodcartselected' => 'sometimes|array',
            'packagename' => 'required|unique:packages,packagename',
            'packageitem' => 'required',
            'fee' => 'nullable|numeric',
        ]);

        $packagename = $request->input('packagename');
        if (Package::where('packagename', $packagename)->exists()) {
            return back()->withErrors([
                'packagename' => 'The package name is already in use. Please choose a different name.'
            ])->withInput();
        }


        // Create a new package entry
        $package = new Package();
        $package->user_id = Auth::id();
        $package->packagename = $packagename; 
        $package->packagedesc = $request->input('total_amount'); 
        $package->discountedprice = $request->input('final');
        $package->discount = $request->input('discount');
        $package->packagephoto = 'images/custom.jpg'; 
        $package->packagetype = "Custom";
        
        // Attempt to save the package
        if (!$package->save()) {
            return redirect()->back()->withErrors('Failed to create package.');
        }

        // Create a custom package entry
        $customPackage = new Custompackage();
        $customPackage->package_id = $package->package_id; // Use the correct ID
        $customPackage->final_price = $request->input('final');
        $customPackage->person = $request->input('person');
        $customPackage->target = $request->input('packageitem');

        // Attempt to save the custom package
        if (!$customPackage->save()) {
            return redirect()->back()->withErrors('Failed to create custom package.');
        }

        if ($request->filled('beefitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('beefitem');
            $customItem->item_type = 'beef';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('beefprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for beef', ['item' => $request->input('beefitem')]);
            }
        }

        if ($request->filled('porkitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('porkitem');
            $customItem->item_type = 'pork';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('porkprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for pork', ['item' => $request->input('porkitem')]);
            }
        }

        if ($request->filled('chickenitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('chickenitem');
            $customItem->item_type = 'chicken';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('chickenprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for chicken', ['item' => $request->input('chickenitem')]);
            }
        }

        if ($request->filled('veggieitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('veggieitem');
            $customItem->item_type = 'veggie';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('veggieprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for veggie', ['item' => $request->input('veggieitem')]);
            }
        }

        if ($request->filled('otheritem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('otheritem');
            $customItem->item_type = 'others';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('otherprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for fish', ['item' => $request->input('otheritem')]);
            }
        }

        if ($request->filled('dessertitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('dessertitem');
            $customItem->item_type = 'dessert';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('dessertprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for fish', ['item' => $request->input('dessertitem')]);
            }
        }


        // Create custom items for food pack items
        if (!empty($request->foodpackitem)) {
            foreach ($request->foodpackitem as $index => $item) {
                $quantity = $request->foodpackquantity[$index] ?? 0; // Get quantity or default to 0
                $price = $request->foodpackprice[$index] ?? 0;
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food_pack';
                    $customItem->quantity = $quantity;
                    $customItem->item_price = $price;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food pack', ['item' => $item]);
                    }
                }
            }
        }

        // Create custom items for food cart items
        if (!empty($request->foodcartselected)) {
            foreach ($request->foodcartselected as $foodcartId) {
                $foodcart = FoodCart::find($foodcartId);
                $price = $request->foodcartprice[$index] ?? 0;
                if ($foodcart) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $foodcart->foodcartname;
                    $customItem->item_type = 'food_cart';
                    $customItem->quantity = 1; // Adjust as necessary
                    $customItem->item_price = $price;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food cart', ['item' => $foodcart->foodcartname]);
                    }
                }
            }
        }

        // Create custom item for lechon
        if ($request->filled('lechonitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('lechonitem');
            $customItem->item_type = 'lechon';
            $customItem->quantity = 1; // Adjust quantity as needed
            $customItem->item_price = $request->input('lechonprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for lechon', ['item' => $request->input('lechonitem')]);
            }
        }

        // Create custom item for cake
        if ($request->filled('cakeitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('cakeitem');
            $customItem->item_type = 'cake';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('cakeprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for cake', ['item' => $request->input('cakeitem')]);
            }
        }

        // Create custom item for clown
        if ($request->filled('clownitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('clownitem');
            $customItem->item_type = 'clown';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('clownprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for clown', ['item' => $request->input('clownitem')]);
            }
        }

        // Create custom item for facepaint
        if ($request->filled('facepaintitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('facepaintitem');
            $customItem->item_type = 'facepaint';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('facepaintprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for facepaint', ['item' => $request->input('facepaintitem')]);
            }
        }

        // Create custom item for setup
        if ($request->filled('setupitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('setupitem');
            $customItem->item_type = 'setup';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('setupprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for setup', ['item' => $request->input('setupitem')]);
            }
        }

        // Add service fee as a custom item
        if ($request->has('fee') && $request->input('fee') !== null) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('fee');  // Fee is used as item_name
            $customItem->item_type = 'service_fee';  // Set item_type to 'service_fee'
            $customItem->item_price = $request->input('fee');
            $customItem->quantity = 1; // Fee is typically a one-time charge, so quantity is set to 1

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for service fee', ['fee' => $request->input('fee')]);
            }
        } else {
            // Log if no fee is provided
            Log::warning('No fee provided for the custom package', ['user_id' => Auth::id()]);
        }


        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Package Created';
        $log->description = $package->packagename . " under " . $customPackage->target . " package created by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();


        // Return success message
        return redirect()->back()->with('success', 'Custom package created successfully!');
    }

    public function storeDirect(Request $request, $appointment_id)
    {

        $request->validate([
            // 'package_id' => 'required|exists:packages,package_id',
            'final' => 'required|numeric',
            // 'packagename' => 'required',
            'foodpackitem' => 'required|array',
            'foodpackquantity' => 'required|array',
            'foodcartselected' => 'sometimes|array',
            // 'packagename' => 'required|unique:packages,packagename',
            'packageitem' => 'required',
            'fee' => 'nullable|numeric',
        ]);

        // $packagename = $request->input('packagename');
        // if (Package::where('packagename', $packagename)->exists()) {
        //     return back()->withErrors([
        //         'packagename' => 'The package name is already in use. Please choose a different name.'
        //     ])->withInput();
        // }


        // Create a new package entry
        $package = new Package();
        $package->user_id = Auth::id();
        // $package->packagename = $packagename; 
        $package->packagedesc = $request->input('total_amount'); 
        $package->discountedprice = $request->input('final');
        $package->discount = $request->input('discount');
        $package->packagephoto = 'images/custom.jpg'; 
        $package->packagetype = "Custom";
        
        // Attempt to save the package
        if (!$package->save()) {
            return redirect()->back()->withErrors('Failed to create package.');
        }

        // Create a custom package entry
        $customPackage = new Custompackage();
        $customPackage->package_id = $package->package_id; // Use the correct ID
        $customPackage->final_price = $request->input('final');
        $customPackage->person = $request->input('person');
        $customPackage->target = $request->input('packageitem');

        // Attempt to save the custom package
        if (!$customPackage->save()) {
            return redirect()->back()->withErrors('Failed to create custom package.');
        }

        if ($request->filled('beefitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('beefitem');
            $customItem->item_type = 'beef';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('beefprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for beef', ['item' => $request->input('beefitem')]);
            }
        }

        if ($request->filled('porkitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('porkitem');
            $customItem->item_type = 'pork';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('porkprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for pork', ['item' => $request->input('porkitem')]);
            }
        }

        if ($request->filled('chickenitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('chickenitem');
            $customItem->item_type = 'chicken';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('chickenprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for chicken', ['item' => $request->input('chickenitem')]);
            }
        }

        if ($request->filled('veggieitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('veggieitem');
            $customItem->item_type = 'veggie';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('veggieprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for veggie', ['item' => $request->input('veggieitem')]);
            }
        }

        if ($request->filled('otheritem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('otheritem');
            $customItem->item_type = 'others';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('otherprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for fish', ['item' => $request->input('otheritem')]);
            }
        }

        if ($request->filled('dessertitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('dessertitem');
            $customItem->item_type = 'dessert';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('dessertprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for fish', ['item' => $request->input('dessertitem')]);
            }
        }


        // Create custom items for food pack items
        if (!empty($request->foodpackitem)) {
            foreach ($request->foodpackitem as $index => $item) {
                $quantity = $request->foodpackquantity[$index] ?? 0; // Get quantity or default to 0
                $price = $request->foodpackprice[$index] ?? 0;
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food_pack';
                    $customItem->quantity = $quantity;
                    $customItem->item_price = $price;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food pack', ['item' => $item]);
                    }
                }
            }
        }

        // Create custom items for food cart items
        if (!empty($request->foodcartselected)) {
            foreach ($request->foodcartselected as $foodcartId) {
                $foodcart = FoodCart::find($foodcartId);
                $price = $request->foodcartprice[$index] ?? 0;
                if ($foodcart) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $foodcart->foodcartname;
                    $customItem->item_type = 'food_cart';
                    $customItem->quantity = 1; // Adjust as necessary
                    $customItem->item_price = $price;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food cart', ['item' => $foodcart->foodcartname]);
                    }
                }
            }
        }

        // Create custom item for lechon
        if ($request->filled('lechonitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('lechonitem');
            $customItem->item_type = 'lechon';
            $customItem->quantity = 1; // Adjust quantity as needed
            $customItem->item_price = $request->input('lechonprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for lechon', ['item' => $request->input('lechonitem')]);
            }
        }

        // Create custom item for cake
        if ($request->filled('cakeitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('cakeitem');
            $customItem->item_type = 'cake';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('cakeprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for cake', ['item' => $request->input('cakeitem')]);
            }
        }

        // Create custom item for clown
        if ($request->filled('clownitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('clownitem');
            $customItem->item_type = 'clown';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('clownprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for clown', ['item' => $request->input('clownitem')]);
            }
        }

        // Create custom item for facepaint
        if ($request->filled('facepaintitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('facepaintitem');
            $customItem->item_type = 'facepaint';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('facepaintprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for facepaint', ['item' => $request->input('facepaintitem')]);
            }
        }

        // Create custom item for setup
        if ($request->filled('setupitem')) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('setupitem');
            $customItem->item_type = 'setup';
            $customItem->quantity = 1;
            $customItem->item_price = $request->input('setupprice');

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for setup', ['item' => $request->input('setupitem')]);
            }
        }

                if ($request->has('fee') && $request->input('fee') !== null) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input('fee');  // Fee is used as item_name
            $customItem->item_type = 'service_fee';  // Set item_type to 'service_fee'
            $customItem->item_price = $request->input('fee');
            $customItem->quantity = 1; // Fee is typically a one-time charge, so quantity is set to 1

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for service fee', ['fee' => $request->input('fee')]);
            }
        } else {
            // Log if no fee is provided
            Log::warning('No fee provided for the custom package', ['user_id' => Auth::id()]);
        }

        $appointment = Appointment::find($appointment_id);
        if ($appointment) {
            $appointment->package_id = $package->package_id;
            $appointment->save(); 

            Log::info("Appointment {$appointment_id} is now associated with package {$package->package_id}");
        } else {
            return back()->withErrors('Appointment not found.');
        }

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Package Created';
        $log->description = $customPackage->target . " package created for event on " .$DateFormatted . " by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();


        // Return success message
        return redirect()->route('manager.pendingView', $appointment_id)->with('success', 'Package created successfully!');
    }


    public function update(Request $request, $package_id)
    {
        // Validate incoming request
        $request->validate([
            'final' => 'required|numeric',
            'packagename' => 'required',
            'foodpackitem' => 'required|array',
            'foodpackquantity' => 'required|array',
            'foodcartselected' => 'sometimes|array',
            'packagename' => 'required|unique:packages,packagename,' . $package_id . ',package_id', // Exclude current package from uniqueness check
            'packageitem' => 'required',
            'fee' => 'nullable|numeric',
        ]);

        $packagename = $request->input('packagename');
        if (Package::where('packagename', $packagename)
            ->where('package_id', '!=', $package_id)
            ->exists()) {
            return back()->withErrors([
                'packagename' => 'The package name is already in use. Please choose a different name.'
            ])->withInput();
        }

        // Find the package to update
        $package = Package::find($package_id);

        if (!$package) {
            return redirect()->back()->withErrors('Package not found.');
        }

        // Update package details
        $package->packagename = $request->input('packagename');
        $package->packagedesc = $request->input('total_amount'); 
        $package->discountedprice = $request->input('final');
        // You might want to update package photo or other fields, if necessary
        // $package->packagephoto = $request->input('new_photo') ?? 'images/custom.jpg'; 

        // Attempt to save the updated package
        if (!$package->save()) {
            return redirect()->back()->withErrors('Failed to update package.');
        }

        // Find and update the custom package
        $customPackage = Custompackage::where('package_id', $package->package_id)->first();

        if (!$customPackage) {
            return redirect()->back()->withErrors('Custom package not found.');
        }

        $customPackage->final_price = $request->input('final');
        $customPackage->person = $request->input('person');
        $customPackage->target = $request->input('packageitem');

        if (!$customPackage->save()) {
            return redirect()->back()->withErrors('Failed to update custom package.');
        }

        // Update the custom items
        // First, delete existing items if you want to allow full re-configuration of the package
        Customitem::where('custompackage_id', $customPackage->custompackage_id)->delete();

        // Re-add items (same logic as the store method, now for updates)
        // Re-add custom items for individual ingredients
        $this->addCustomItem($request, 'beefitem', 'beef', $customPackage, $request->input('beefprice'));
        $this->addCustomItem($request, 'porkitem', 'pork', $customPackage, $request->input('porkprice'));
        $this->addCustomItem($request, 'chickenitem', 'chicken', $customPackage, $request->input('chickenprice'));
        $this->addCustomItem($request, 'veggieitem', 'veggie', $customPackage, $request->input('veggieprice'));
        $this->addCustomItem($request, 'otheritem', 'others', $customPackage, $request->input('otherprice'));
        $this->addCustomItem($request, 'dessertitem', 'dessert', $customPackage, $request->input('dessertprice'));

        // Re-add custom items for food pack items
        if (!empty($request->foodpackitem)) {
            foreach ($request->foodpackitem as $index => $item) {
                $quantity = $request->foodpackquantity[$index] ?? 0; // Get quantity or default to 0
                $foodpackPrice = $request->foodpackprice[$index] ?? 0;
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food_pack';
                    $customItem->quantity = $quantity;
                    $customItem->item_price = $foodpackPrice;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food pack', ['item' => $item]);
                    }
                }
            }
        }

        // Re-add custom items for food cart items
        if (!empty($request->foodcartselected)) {
            foreach ($request->foodcartselected as $foodcartId) {
                $foodcart = FoodCart::find($foodcartId);
                if ($foodcart) {
                    $foodcartPrice = $request->input('foodcartprice')[$index];
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $foodcart->foodcartname;
                    $customItem->item_type = 'food_cart';
                    $customItem->quantity = 1; // Adjust as necessary
                    $customItem->item_price = $foodcartPrice;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food cart', ['item' => $foodcart->foodcartname]);
                    }
                }
            }
        }

        // Re-add custom items for other predefined items (like lechon, cake, clown, etc.)
        $this->addCustomItem($request, 'lechonitem', 'lechon', $customPackage, $request->input('lechonprice'));
        $this->addCustomItem($request, 'cakeitem', 'cake', $customPackage, $request->input('cakeprice'));
        $this->addCustomItem($request, 'clownitem', 'clown', $customPackage, $request->input('clownprice'));
        $this->addCustomItem($request, 'facepaintitem', 'facepaint', $customPackage, $request->input('facepaintprice'));
        $this->addCustomItem($request, 'setupitem', 'setup', $customPackage, $request->input('setupprice'));
        $this->addCustomItem($request, 'fee', 'service_fee', $customPackage, $request->input('fee'));

        // Log the update action
        $use = Auth::user();
        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Package Updated';
        $log->description = $package->packagename . " under " . $customPackage->target . " edited created by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        // Return success message
        return redirect()->back()->with('success', 'Custom package updated successfully!');
    }

    public function updateBooked(Request $request, $package_id, $appointment_id)
    {
        // Validate incoming request
        $request->validate([
            'final' => 'required|numeric',
            // 'packagename' => 'required',
            'foodpackitem' => 'required|array',
            'foodpackquantity' => 'required|array',
            'foodcartselected' => 'sometimes|array',
            // 'packagename' => 'required|unique:packages,packagename,' . $package_id . ',package_id', // Exclude current package from uniqueness check
            'packageitem' => 'required',
            'fee' => 'nullable|numeric',
        ]);

        // $packagename = $request->input('packagename');
        // if (Package::where('packagename', $packagename)
        //     ->where('package_id', '!=', $package_id)
        //     ->exists()) {
        //     return back()->withErrors([
        //         'packagename' => 'The package name is already in use. Please choose a different name.'
        //     ])->withInput();
        // }

        // Find the package to update
        $package = Package::find($package_id);

        if (!$package) {
            return redirect()->back()->withErrors('Package not found.');
        }

        // Retrieve all appointments connected to the package
        $appointments = Appointment::where('package_id', $package_id)->get();

        // Ensure that the new final price is not less than the deposit of any connected appointment
        foreach ($appointments as $appointment) {
            if ($request->input('final') < $appointment->deposit) {
                return redirect()->back()->withErrors(
                    "The final price cannot be less than the deposit of ₱{$appointment->deposit} amount of the connected event"
                );
            }
        }

        // Update package details
        // $package->packagename = $request->input('packagename');
        $package->packagedesc = $request->input('total_amount'); 
        $package->discountedprice = $request->input('final');
        // You might want to update package photo or other fields, if necessary
        // $package->packagephoto = $request->input('new_photo') ?? 'images/custom.jpg'; 

        // Attempt to save the updated package
        if (!$package->save()) {
            return redirect()->back()->withErrors('Failed to update package.');
        }

        // Find and update the custom package
        $customPackage = Custompackage::where('package_id', $package->package_id)->first();

        if (!$customPackage) {
            return redirect()->back()->withErrors('Custom package not found.');
        }

        $customPackage->final_price = $request->input('final');
        $customPackage->person = $request->input('person');
        $customPackage->target = $request->input('packageitem');

        if (!$customPackage->save()) {
            return redirect()->back()->withErrors('Failed to update custom package.');
        }

        // Update the custom items
        // First, delete existing items if you want to allow full re-configuration of the package
        Customitem::where('custompackage_id', $customPackage->custompackage_id)->delete();

        // Re-add items (same logic as the store method, now for updates)
        // Re-add custom items for individual ingredients
        $this->addCustomItem($request, 'beefitem', 'beef', $customPackage, $request->input('beefprice'));
        $this->addCustomItem($request, 'porkitem', 'pork', $customPackage, $request->input('porkprice'));
        $this->addCustomItem($request, 'chickenitem', 'chicken', $customPackage, $request->input('chickenprice'));
        $this->addCustomItem($request, 'veggieitem', 'veggie', $customPackage, $request->input('veggieprice'));
        $this->addCustomItem($request, 'otheritem', 'others', $customPackage, $request->input('otherprice'));
        $this->addCustomItem($request, 'dessertitem', 'dessert', $customPackage, $request->input('dessertprice'));

        // Re-add custom items for food pack items
        if (!empty($request->foodpackitem)) {
            foreach ($request->foodpackitem as $index => $item) {
                $quantity = $request->foodpackquantity[$index] ?? 0; // Get quantity or default to 0
                $foodpackPrice = $request->foodpackprice[$index] ?? 0;
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food_pack';
                    $customItem->quantity = $quantity;
                    $customItem->item_price = $foodpackPrice;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food pack', ['item' => $item]);
                    }
                }
            }
        }

        // Re-add custom items for food cart items
        if (!empty($request->foodcartselected)) {
            foreach ($request->foodcartselected as $foodcartId) {
                $foodcart = FoodCart::find($foodcartId);
                if ($foodcart) {
                    $foodcartPrice = $request->input('foodcartprice')[$index];
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $foodcart->foodcartname;
                    $customItem->item_type = 'food_cart';
                    $customItem->quantity = 1; // Adjust as necessary
                    $customItem->item_price = $foodcartPrice;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food cart', ['item' => $foodcart->foodcartname]);
                    }
                }
            }
        }

        // Re-add custom items for other predefined items (like lechon, cake, clown, etc.)
        $this->addCustomItem($request, 'lechonitem', 'lechon', $customPackage, $request->input('lechonprice'));
        $this->addCustomItem($request, 'cakeitem', 'cake', $customPackage, $request->input('cakeprice'));
        $this->addCustomItem($request, 'clownitem', 'clown', $customPackage, $request->input('clownprice'));
        $this->addCustomItem($request, 'facepaintitem', 'facepaint', $customPackage, $request->input('facepaintprice'));
        $this->addCustomItem($request, 'setupitem', 'setup', $customPackage, $request->input('setupprice'));
        $this->addCustomItem($request, 'fee', 'service_fee', $customPackage, $request->input('fee'));

        // Find the specific appointment by its ID
        $appointment = Appointment::find($appointment_id);

        if (!$appointment) {
            return redirect()->back()->withErrors('Appointment not found.');
        }

        // Update the balance for the specific appointment
        $appointment->balance = $package->packagedesc - $appointment->deposit;
        $appointment->save();

        $DateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');
        // Log the update action
        $use = Auth::user();
        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Package Updated';
        $log->description = $customPackage->target . " package edited for event on " .$DateFormatted . " by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        // Get the user who made the appointment
        $user = $appointment->user; // Assuming you have a relation between Appointment and User models

        // Format the appointment date and time
        $appointmentDateFormatted = Carbon::parse($appointment->edate)->format('F j, Y');

        // Create the email content
        $emailContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                <h1 style='color: #333;'>The package of your event: {$appointment->type} on {$appointmentDateFormatted} have been updated</h1>
                <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                <p>We look forward on making your next event wonderful.</p>
                <p style='color: #555;'>Message us on our Facebook page or on our Website for more details</p>
            </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('Event Package Updated')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            // return redirect()->back()->with('error', 'Failed to send confirmation email.');
            if ($appointment->status == 'booked') {
                return redirect()->route('manager.bookedView', $appointment_id)->with('success', 'Package updated successfully!');
            } else {
                return redirect()->route('manager.pendingView', $appointment_id)->with('success', 'Package updated successfully!');
            }
        }

        // Return success message
        // return redirect()->back()->with('success', 'Custom package updated successfully!');
        if ($appointment->status == 'booked') {
            return redirect()->route('manager.bookedView', $appointment_id)->with('success', 'Package updated successfully!');
        } else {
            return redirect()->route('manager.pendingView', $appointment_id)->with('success', 'Package updated successfully!');
        }
    }

    /**
     * Helper method to add or update a custom item
     */
    private function addCustomItem(Request $request, $field, $itemType, $customPackage, $itemPrice = null)
    {
        if ($request->filled($field)) {
            $customItem = new Customitem();
            $customItem->custompackage_id = $customPackage->custompackage_id;
            $customItem->item_name = $request->input($field);
            $customItem->item_type = $itemType;
            $customItem->quantity = 1;

            // If price is provided, save it
        if ($itemPrice !== null) {
            $customItem->item_price = $itemPrice;
        }

            if (!$customItem->save()) {
                Log::error("Failed to save custom item for $itemType", ['item' => $request->input($field)]);
            }
        }
    }






    public function foodStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'foodname' => 'required|string|max:255',
            'foodprice' => 'required|numeric|min:0',
        ]);

        $food = new Food($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Food-Item Created';
        $log->description = $request->foodname . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function foodUpdate(Request $request, string $food_id)
    {
        $request->validate([
            'foodname' => 'required|string|max:255',
            'foodprice' => 'required|numeric|min:0',
        ]);
        
        $food = Food::find($food_id);
        $food->foodname = $request->input('foodname');
        $food->foodprice = $request->input('foodprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Food-Item Updated';
        $log->description = $request->foodname . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function foodDestroy(string $food_id)
    {
        $food = Food::find($food_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Food-Item Deleted';
            $log->description = $food->foodname . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }

    public function beefStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'beefname' => 'required|string|max:255',
            'beefprice' => 'required|numeric|min:0',
        ]);

        $food = new Beef($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Beef-Item Created';
        $log->description = $request->beefname . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function beefUpdate(Request $request, string $beef_id)
    {
        $request->validate([
            'beefname' => 'required|string|max:255',
            'beefprice' => 'required|numeric|min:0',
        ]);
        
        $food = Beef::find($beef_id);
        $food->beefname = $request->input('beefname');
        $food->beefprice = $request->input('beefprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Beef-Item Updated';
        $log->description = $request->beefname . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function beefDestroy(string $beef_id)
    {
        $food = Beef::find($beef_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Beef-Item Deleted';
            $log->description = $food->beefname . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }

    public function porkStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'porkname' => 'required|string|max:255',
            'prokprice' => 'required|numeric|min:0',
        ]);

        $food = new Pork($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Pork-Item Created';
        $log->description = $request->beefname . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function porkUpdate(Request $request, string $pork_id)
    {
        $request->validate([
            'porkname' => 'required|string|max:255',
            'prokprice' => 'required|numeric|min:0',
        ]);
        
        $food = Pork::find($pork_id);
        $food->porkname = $request->input('porkname');
        $food->prokprice = $request->input('prokprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Pork-Item Updated';
        $log->description = $request->porkname . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function porkDestroy(string $pork_id)
    {
        $food = Pork::find($pork_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Pork-Item Deleted';
            $log->description = $food->porkname . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }

    public function chickenStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'chickenname' => 'required|string|max:255',
            'chickenprice' => 'required|numeric|min:0',
        ]);

        $food = new Chicken($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Chicken-Item Created';
        $log->description = $request->chickenname . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function chickenUpdate(Request $request, string $chicken_id)
    {
        $request->validate([
            'chickenname' => 'required|string|max:255',
            'chickenprice' => 'required|numeric|min:0',
        ]);
        
        $food = Chicken::find($chicken_id);
        $food->chickenname = $request->input('chickenname');
        $food->chickenprice = $request->input('chickenprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Chicken-Item Updated';
        $log->description = $request->chickenname . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function chickenDestroy(string $chicken_id)
    {
        $food = Chicken::find($chicken_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Pork-Item Deleted';
            $log->description = $food->chickenname . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }

    public function veggieStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'veggiename' => 'required|string|max:255',
            'veggieprice' => 'required|numeric|min:0',
        ]);

        $food = new Veggie($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Veggie-Item Created';
        $log->description = $request->veggiename . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function veggieUpdate(Request $request, string $veggie_id)
    {
        $request->validate([
            'veggiename' => 'required|string|max:255',
            'veggieprice' => 'required|numeric|min:0',
        ]);
        
        $food = Veggie::find($veggie_id);
        $food->veggiename = $request->input('veggiename');
        $food->veggieprice = $request->input('veggieprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Veggie-Item Updated';
        $log->description = $request->veggiename . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function veggieDestroy(string $veggie_id)
    {
        $food = Veggie::find($veggie_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Veggie-Item Deleted';
            $log->description = $food->veggiename . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }

    public function otherStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'othername' => 'required|string|max:255',
            'otherprice' => 'required|numeric|min:0',
        ]);

        $food = new Others($request->all());
        $food->user_id = Auth::id();
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Food-Item Created';
        $log->description = $request->othername . " food item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item added successfully!');
    }
    public function otherUpdate(Request $request, string $other_id)
    {
        $request->validate([
            'othername' => 'required|string|max:255',
            'otherprice' => 'required|numeric|min:0',
        ]);
        
        $food = Others::find($other_id);
        $food->othername = $request->input('othername');
        $food->otherprice = $request->input('otherprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Food-Item Updated';
        $log->description = $request->othername . " food item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Food item updated successfully!');
    }
    public function otherDestroy(string $other_id)
    {
        $food = Others::find($other_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Food-Item Deleted';
            $log->description = $food->othername . " food item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Food item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Food item not found.');
    }


    public function foodpackStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'foodpackname' => 'required|string|max:255',
            'foodpackprice' => 'required|numeric|min:0',
        ]);

        $foodpack = new Foodpack($request->all());
        $foodpack->user_id = Auth::id();
        $foodpack->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'FoodPack-Item Created';
        $log->description = $request->foodpackname . " foodpack item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Foodpack item added successfully!');
    }
    public function foodpackUpdate(Request $request, string $foodpack_id)
    {
        $request->validate([
            'foodpackname' => 'required|string|max:255',
            'foodpackprice' => 'required|numeric|min:0',
        ]);
        
        $food = Foodpack::find($foodpack_id);
        $food->foodpackname = $request->input('foodpackname');
        $food->foodpackprice = $request->input('foodpackprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'FoodPack-Item Updated';
        $log->description = $request->foodpackname . " foodpack item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Foodcart item updated successfully!');
    }
    public function foodpackDestroy(string $foodpack_id)
    {
        $food = Foodpack::find($foodpack_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'FoodPack-Item Deleted';
            $log->description = $food->foodpackname . " foodpack item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Foodpack item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Foodcart item not found.');
    }


    public function foodcartStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'foodcartname' => 'required|string|max:255',
            'foodcartprice' => 'required|numeric|min:0',
        ]);

        $foodcart = new Foodcart($request->all());
        $foodcart->user_id = Auth::id();
        $foodcart->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'FoodCart-Item Created';
        $log->description = $request->foodcartname . " foodcart item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Foodcart item added successfully!');
    }
    public function foodcartUpdate(Request $request, string $foodcart_id)
    {
        $request->validate([
            'foodcartname' => 'required|string|max:255',
            'foodcartprice' => 'required|numeric|min:0',
        ]);
        
        $food = Foodcart::find($foodcart_id);
        $food->foodcartname = $request->input('foodcartname');
        $food->foodcartprice = $request->input('foodcartprice');
        $food->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'FoodCart-Item Updated';
        $log->description = $request->foodcartname . " foodcart item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Foodcart item updated successfully!');
    }
    public function foodcartDestroy(string $foodcart_id)
    {
        $food = Foodcart::find($foodcart_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'FoodCart-Item Deleted';
            $log->description = $food->foodcartname . " foodcart item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();


            return redirect()->back()->with('success', 'Foodcart item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Foodcart item not found.');
    }


    public function lechonStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'lechonname' => 'required|string|max:255',
            'lechonprice' => 'required|numeric|min:0',
        ]);

        $lechon = new Lechon($request->all());
        $lechon->user_id = Auth::id();
        $lechon->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Lechon-Item Created';
        $log->description = $request->lechonname . " lechon item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Lechon item added successfully!');
    }
    public function lechonUpdate(Request $request, string $lechon_id)
    {
        $request->validate([
            'lechonname' => 'required|string|max:255',
            'lechonprice' => 'required|numeric|min:0',
        ]);
        
        $lechon = Lechon::find($lechon_id);
        $lechon->lechonname = $request->input('lechonname');
        $lechon->lechonprice = $request->input('lechonprice');
        $lechon->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Lechon-Item Updated';
        $log->description = $request->lechonname . " lechon item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Lechon item updated successfully!');
    }
    public function lechonDestroy(string $lechon_id)
    {
        $food = Lechon::find($lechon_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Lechon-Item Deleted';
            $log->description = $food->lechonname . " lechon item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Lechon item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Lechon item not found.');
    }


    public function cakeStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'cakename' => 'required|string|max:255',
            'cakeprice' => 'required|numeric|min:0',
        ]);

        $cake = new Cake($request->all());
        $cake->user_id = Auth::id();
        $cake->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Cake-Item Created';
        $log->description = $request->cakename . " Cake item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Cake item added successfully!');
    }
    public function cakeUpdate(Request $request, string $cake_id)
    {
        $request->validate([
            'cakename' => 'required|string|max:255',
            'cakeprice' => 'required|numeric|min:0',
        ]);
        
        $cake = Cake::find($cake_id);
        $cake->cakename = $request->input('cakename');
        $cake->cakeprice = $request->input('cakeprice');
        $cake->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Cake-Item Updated';
        $log->description = $request->cakename . " Cake item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Cake item updated successfully!');
    }
    public function cakeDestroy(string $cake_id)
    {
        $food = Cake::find($cake_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Cake-Item Deleted';
            $log->description = $food->cakename . " Cake item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Cake item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Cake item not found.');
    }


    public function clownStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'clownname' => 'required|string|max:255',
            'clownprice' => 'required|numeric|min:0',
        ]);

        $clown = new Clown($request->all());
        $clown->user_id = Auth::id();
        $clown->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Clown/Emcee-Item Created';
        $log->description = $request->clownname . " clown/emcee item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Clown/Emcee item added successfully!');
    }
    public function clownUpdate(Request $request, string $clown_id)
    {
        $request->validate([
            'clownname' => 'required|string|max:255',
            'clownprice' => 'required|numeric|min:0',
        ]);
        
        $clown = Clown::find($clown_id);
        $clown->clownname = $request->input('clownname');
        $clown->clownprice = $request->input('clownprice');
        $clown->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Clown/Emcee-Item Updated';
        $log->description = $request->clownname . " clown/emcee item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Clown/Emcee item updated successfully!');
    }
    public function clownDestroy(string $clown_id)
    {
        $food = Clown::find($clown_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Clown/Emcee-Item Deleted';
            $log->description = $food->clownname . " clown/emcee item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();
            
            return redirect()->back()->with('success', 'Clown/Emcee item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Clown/Emcee item not found.');
    }


    public function setupStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'setupname' => 'required|string|max:255',
            'setupprice' => 'required|numeric|min:0',
        ]);

        $setup = new Setup($request->all());
        $setup->user_id = Auth::id();
        $setup->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Setup-Item Created';
        $log->description = $request->setupname . " setup item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Setup item added successfully!');
    }
    public function setupUpdate(Request $request, string $setup_id)
    {
        $request->validate([
            'setupname' => 'required|string|max:255',
            'setupprice' => 'required|numeric|min:0',
        ]);
        
        $setup = Setup::find($setup_id);
        $setup->setupname = $request->input('setupname');
        $setup->setupprice = $request->input('setupprice');
        $setup->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Setup-Item Updated';
        $log->description = $request->setupname . " setup item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Setup item updated successfully!');
    }
    public function setupDestroy(string $setup_id)
    {
        $food = Setup::find($setup_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Setup-Item Deleted';
            $log->description = $food->setupname . " setup item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();
            
            return redirect()->back()->with('success', 'Setup item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Setup item not found.');
    }


    public function facepaintStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'facepaintname' => 'required|string|max:255',
            'facepaintprice' => 'required|numeric|min:0',
        ]);

        $facepaint = new Facepaint($request->all());
        $facepaint->user_id = Auth::id();
        $facepaint->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Facepaint-Item Created';
        $log->description = $request->facepaintname . " facepaint item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Setup item added successfully!');
    }
    public function facepaintUpdate(Request $request, string $facepaint_id)
    {
        $request->validate([
            'facepaintname' => 'required|string|max:255',
            'facepaintprice' => 'required|numeric|min:0',
        ]);
        
        $facepaint = Facepaint::find($facepaint_id);
        $facepaint->facepaintname = $request->input('facepaintname');
        $facepaint->facepaintprice = $request->input('facepaintprice');
        $facepaint->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Facepaint-Item Updated';
        $log->description = $request->facepaintname . " facepaint item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Facepaint item updated successfully!');
    }
    public function facepaintDestroy(string $facepaint_id)
    {
        $food = Facepaint::find($facepaint_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Facepaint-Item Deleted';
            $log->description = $food->facepaintname . " facepaint item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Facepaint item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Facepaint item not found.');
    }

    public function dessertStore(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'dessertname' => 'required|string|max:255',
        ]);

        $dessert = new Dessert($request->all());
        $dessert->user_id = Auth::id();
        $dessert->dessertprice = 0.00;
        $dessert->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Dessert-Item Created';
        $log->description = $request->dessertname . " dessert item has been added by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Dessert item added successfully!');
    }
    public function dessertUpdate(Request $request, string $dessert_id)
    {
        $request->validate([
            'dessertname' => 'required|string|max:255',
        ]);
        
        $dessert = Dessert::find($dessert_id);
        $dessert->dessertname = $request->input('dessertname');
        $dessert->dessertprice = 0.00;
        $dessert->save();

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Dessert-Item Updated';
        $log->description = $request->dessertname . " dessert item has been updated by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Dessert item updated successfully!');
    }
    public function dessertDestroy(string $dessert_id)
    {
        $food = Dessert::find($dessert_id);

        if ($food) {
            $food->delete();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Dessert-Item Deleted';
            $log->description = $food->dessertname . " dessert item has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Setup item deleted successfully!');
        }

        return redirect()->back()->with('error', 'Dessert item not found.');
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $package_id)
    {
        // Check for associated appointments with the package
        $hasPendingOrBookedAppointments = Appointment::where('package_id', $package_id)
        ->whereIn('status', ['pending', 'booked'])
        ->exists();

        if ($hasPendingOrBookedAppointments) {
            // Return with an error message if there are associated appointments
            return redirect()->back()->with('error', 'Cannot delete this package because it is associated with appointments that are pending or booked.');
        }

        // Update any appointments with 'done' status to set package_id to null
        Appointment::where('package_id', $package_id)
        ->whereIn('status', ['done', 'cancelled', 'cancelled'])
        ->update(['package_id' => null]);

        // Find the custom package
        $customPackage = CustomPackage::where('package_id', $package_id)->first();

        // If the custom package exists, delete associated custom items
        if ($customPackage) {
            // Delete related custom items
            CustomItem::where('custompackage_id', $customPackage->custompackage_id)->delete();

            // Delete the custom package
            $customPackage->delete();
        }

        // Finally, delete the main package
        $package = Package::findOrFail($package_id);

        // Check if the package has a photo and delete it
        if ($package->packagephoto && file_exists(public_path($package->packagephoto)) && $package->packagetype !== 'Custom') {
            unlink(public_path($package->packagephoto)); // Delete the photo from the server
        }

        $package->delete();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Custom Package Deleted';
            $log->description = $package->packagename . " custom package has been deleted by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();

        // Redirect back with a success message
        return redirect()->route('managerviewpackage')->with('success', 'Custom package deleted successfully.');
    }
}
