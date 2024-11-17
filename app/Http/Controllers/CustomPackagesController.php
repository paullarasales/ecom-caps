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

class CustomPackagesController extends Controller
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
        // Log::info('Incoming request data:', $request->all());
        // Validate incoming request
        $request->validate([
            // 'package_id' => 'required|exists:packages,package_id',
            'final' => 'required|numeric',
            'packagename' => 'required',
            'fooditem' => 'required|array',
            'foodquantity' => 'required|array',
            'foodpackitem' => 'required|array',
            'foodpackquantity' => 'required|array',
            'foodcartselected' => 'sometimes|array',
        ]);

        // Log the request data for debugging
        // dd($request->all());
        // Log::info('Request data:', $request->all());

        // Create a new package entry
        $package = new Package();
        $package->user_id = Auth::id();
        $package->packagename = $request->input('packagename'); 
        $package->packagedesc = $request->input('final'); 
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

        // Attempt to save the custom package
        if (!$customPackage->save()) {
            return redirect()->back()->withErrors('Failed to create custom package.');
        }

        // Create custom items entries
        // For food items
        // Create custom items for food items
        if (!empty($request->fooditem)) {
            foreach ($request->fooditem as $index => $item) {
                $quantity = $request->foodquantity[$index] ?? 0; // Get quantity or default to 0
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food';
                    $customItem->quantity = $quantity;

                    if (!$customItem->save()) {
                        Log::error('Failed to save custom item for food', ['item' => $item]);
                    }
                }
            }
        }

        // Create custom items for food pack items
        if (!empty($request->foodpackitem)) {
            foreach ($request->foodpackitem as $index => $item) {
                $quantity = $request->foodpackquantity[$index] ?? 0; // Get quantity or default to 0
                if ($quantity > 0) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $item;
                    $customItem->item_type = 'food_pack';
                    $customItem->quantity = $quantity;

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
                if ($foodcart) {
                    $customItem = new Customitem();
                    $customItem->custompackage_id = $customPackage->custompackage_id;
                    $customItem->item_name = $foodcart->foodcartname . ' ₱' . number_format($foodcart->foodcartprice, 2);
                    $customItem->item_type = 'food_cart';
                    $customItem->quantity = 1; // Adjust as necessary

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

            if (!$customItem->save()) {
                Log::error('Failed to save custom item for setup', ['item' => $request->input('setupitem')]);
            }
        }

        $use = Auth::user();

        $log = new ModelsLog();
        $log->user_id = Auth::id();
        $log->action = 'Package Created';
        $log->description = $package->packagename . " package created by " . $use->firstname . " " . $use->lastname;
        $log->logdate = now();
        $log->save();


        // Return success message
        return redirect()->back()->with('alert', 'Custom package created successfully!');
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

        return redirect()->route('customfood')->with('alert', 'Food item added successfully!');
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

        return redirect()->route('customfood.view')->with('alert', 'Food item updated successfully!');
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

            return redirect()->route('customfood')->with('alert', 'Food item deleted successfully!');
        }

        return redirect()->route('customfood')->with('error', 'Food item not found.');
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

        return redirect()->route('customfoodpack')->with('alert', 'Foodpack item added successfully!');
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

        return redirect()->route('customfoodpack.view')->with('alert', 'Foodcart item updated successfully!');
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

            return redirect()->route('customfoodpack')->with('alert', 'Foodpack item deleted successfully!');
        }

        return redirect()->route('customfoodpack')->with('error', 'Foodcart item not found.');
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

        return redirect()->route('customfoodcart')->with('alert', 'Foodcart item added successfully!');
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

        return redirect()->route('customfoodcart.view')->with('alert', 'Foodcart item updated successfully!');
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

            return redirect()->route('customfoodcart')->with('alert', 'Foodcart item deleted successfully!');
        }

        return redirect()->route('customfoodcart')->with('error', 'Foodcart item not found.');
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

        return redirect()->route('customlechon')->with('alert', 'Lechon item added successfully!');
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

        return redirect()->route('customlechon.view')->with('alert', 'Lechon item updated successfully!');
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

            return redirect()->route('customlechon')->with('alert', 'Lechon item deleted successfully!');
        }

        return redirect()->route('customlechon')->with('error', 'Lechon item not found.');
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

        return redirect()->route('customcake')->with('alert', 'Cake item added successfully!');
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

        return redirect()->route('customcake.view')->with('alert', 'Cake item updated successfully!');
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

            return redirect()->route('customcake')->with('alert', 'Cake item deleted successfully!');
        }

        return redirect()->route('customcake')->with('error', 'Cake item not found.');
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

        return redirect()->route('customclown')->with('alert', 'Clown/Emcee item added successfully!');
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

        return redirect()->route('customclown.view')->with('alert', 'Clown/Emcee item updated successfully!');
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

            return redirect()->route('customclown')->with('alert', 'Clown/Emcee item deleted successfully!');
        }

        return redirect()->route('customclown')->with('error', 'Clown/Emcee item not found.');
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

        return redirect()->route('customfacepaint')->with('alert', 'Facepaint item added successfully!');
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

        return redirect()->route('customfacepaint.view')->with('alert', 'Facepaint item updated successfully!');
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

            return redirect()->route('customfacepaint')->with('alert', 'Facepaint item deleted successfully!');
        }

        return redirect()->route('customfacepaint')->with('error', 'Facepaint item not found.');
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

        return redirect()->route('customsetup')->with('alert', 'Setup item added successfully!');
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

        return redirect()->route('customsetup.view')->with('alert', 'Setup item updated successfully!');
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

            return redirect()->route('customsetup')->with('alert', 'Setup item deleted successfully!');
        }

        return redirect()->route('customsetup')->with('error', 'Setup item not found.');
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
        return redirect()->route('viewpackage')->with('alert', 'Custom package deleted successfully.');
    }
}
