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
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Beef;
use App\Models\Pork;
use App\Models\Chicken;
use App\Models\Veggie;
use App\Models\Others;
use App\Models\Package;
use App\Models\Custompackage;
use App\Models\Customitem;
use App\Models\Appointment;

class MgrCustomPackagesPagesController extends Controller
{

    public function customadd()
    {
        $packages = Package::where('packagestatus', 'active')
                            ->where('packagetype', 'Normal')
                            ->get();

        $foods = Food::all();
        $beefs = Beef::all();
        $porks = Pork::all();
        $chickens = Chicken::all();
        $veggies = Veggie::all();
        $others = Others::all();
        $foodpacks = Foodpack::all();
        $foodcarts = Foodcart::all();
        $cake = Cake::all();
        $clown = Clown::all();
        $setup = Setup::all();
        $lechon = Lechon::all();
        $facepaint = Facepaint::all();
        return view('manager.packages-new-add-customize', compact(
            'packages',
            'foods', 
            'foodpacks', 
            'foodcarts', 
            'cake', 
            'clown', 
            'setup', 
            'lechon', 
            'facepaint',
            'beefs',
            'porks',
            'chickens',
            'veggies',
            'others',
        ));
    }

    public function customaddDirect($appointment_id)
    {

        $appointment = Appointment::find($appointment_id);

        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found');
        }

        if (!$appointment->edate) {
            return redirect()->back()->with('error', 'Event date is yet not set');
        }

        $packages = Package::where('packagestatus', 'active')
                            ->where('packagetype', 'Normal')
                            ->get();

        $foods = Food::all();
        $beefs = Beef::all();
        $porks = Pork::all();
        $chickens = Chicken::all();
        $veggies = Veggie::all();
        $others = Others::all();
        $foodpacks = Foodpack::all();
        $foodcarts = Foodcart::all();
        $cake = Cake::all();
        $clown = Clown::all();
        $setup = Setup::all();
        $lechon = Lechon::all();
        $facepaint = Facepaint::all();
        return view('manager.packages-add-custom-direct', compact(
            'appointment',
            'packages',
            'foods', 
            'foodpacks', 
            'foodcarts', 
            'cake', 
            'clown', 
            'setup', 
            'lechon', 
            'facepaint',
            'beefs',
            'porks',
            'chickens',
            'veggies',
            'others',
        ));
    }

    public function customedit($package_id)
    {
        // Retrieve the package
        $package = Package::findOrFail($package_id);

        // Check if the package is tied to any appointment
        $hasAppointments = Appointment::where('package_id', $package_id)->exists();

        if ($hasAppointments) {
            // Redirect back with an error message if tied to an appointment
            return redirect()->back()->with('error', 'This package cannot be edited as it is tied to an appointment. Create new package instead.');
        }

        // Retrieve the associated items for this package
        $customPackage = Custompackage::where('package_id', $package_id)->first();
        $customItems = Customitem::where('custompackage_id', $customPackage->custompackage_id)->get();

        $selectedBeef = $customItems->where('item_type', 'beef')->first();
        $selectedPork = $customItems->where('item_type', 'pork')->first();
        $selectedChicken = $customItems->where('item_type', 'chicken')->first();
        $selectedVeggie = $customItems->where('item_type', 'veggie')->first();
        $selectedOther = $customItems->where('item_type', 'others')->first();
        $selectedCake = $customItems->where('item_type', 'cake')->first();
        $selectedLechon = $customItems->where('item_type', 'lechon')->first();
        $selectedClown = $customItems->where('item_type', 'clown')->first();
        $selectedFacepaint = $customItems->where('item_type', 'facepaint')->first();
        $selectedSetup = $customItems->where('item_type', 'setup')->first();
        $fee = $customItems->where('item_type', 'service_fee')->first();

        $selectedFoodpacks = $customItems->where('item_type', 'food_pack')->pluck('item_name')->toArray();
        $selectedFoodcarts = $customItems->where('item_type', 'food_cart')->pluck('item_name')->toArray();


        // Retrieve other necessary data (foods, packs, etc.)
        $packages = Package::where('packagestatus', 'active')
                            ->where('packagetype', 'Normal')
                            ->get();
        $foods = Food::all();
        $beefs = Beef::all();
        $porks = Pork::all();
        $chickens = Chicken::all();
        $veggies = Veggie::all();
        $others = Others::all();
        $foodpacks = Foodpack::all();
        $foodcarts = Foodcart::all();
        $cake = Cake::all();
        $clown = Clown::all();
        $setup = Setup::all();
        $lechon = Lechon::all();
        $facepaint = Facepaint::all();

        // dd($selectedFoodcarts);

        return view('manager.packages-custom-edit', compact(
            'packages',
            'package', 
            'customPackage', 
            'customItems',
            'foods', 
            'foodpacks', 
            'foodcarts', 
            'cake', 
            'clown', 
            'setup', 
            'lechon', 
            'facepaint',
            'beefs',
            'porks',
            'chickens',
            'veggies',
            'others',
            'selectedBeef',
            'selectedPork',
            'selectedChicken',
            'selectedVeggie',
            'selectedOther',
            'selectedCake',
            'selectedLechon',
            'selectedClown',
            'selectedFacepaint',
            'selectedSetup',
            'selectedFoodpacks',
            'selectedFoodcarts',
            'fee',
        ));
    }

    public function customeditBooked($package_id)
    {
        // Retrieve the package
        $package = Package::findOrFail($package_id);

        // Count the number of appointments tied to the package with specific statuses
        $appointmentCount = Appointment::where('package_id', $package_id)
            ->whereIn('status', ['booked', 'pending', 'cancelled'])
            ->count();

        if ($appointmentCount > 1) {
            // Redirect back with an error message if tied to more than one appointment
            return redirect()->back()->with('error', 'This package cannot be edited as it is tied to multiple appointments. Create a new package instead.');
        }

        // Retrieve the associated items for this package
        $customPackage = Custompackage::where('package_id', $package_id)->first();
        $customItems = Customitem::where('custompackage_id', $customPackage->custompackage_id)->get();

        $selectedBeef = $customItems->where('item_type', 'beef')->first();
        $selectedPork = $customItems->where('item_type', 'pork')->first();
        $selectedChicken = $customItems->where('item_type', 'chicken')->first();
        $selectedVeggie = $customItems->where('item_type', 'veggie')->first();
        $selectedOther = $customItems->where('item_type', 'others')->first();
        $selectedCake = $customItems->where('item_type', 'cake')->first();
        $selectedLechon = $customItems->where('item_type', 'lechon')->first();
        $selectedClown = $customItems->where('item_type', 'clown')->first();
        $selectedFacepaint = $customItems->where('item_type', 'facepaint')->first();
        $selectedSetup = $customItems->where('item_type', 'setup')->first();
        $fee = $customItems->where('item_type', 'service_fee')->first();

        $selectedFoodpacks = $customItems->where('item_type', 'food_pack')->pluck('item_name')->toArray();
        $selectedFoodcarts = $customItems->where('item_type', 'food_cart')->pluck('item_name')->toArray();


        // Retrieve other necessary data (foods, packs, etc.)
        // Retrieve other necessary data (foods, packs, etc.)
        $packages = Package::where('packagestatus', 'active')
                            ->where('packagetype', 'Normal')
                            ->get();
        $foods = Food::all();
        $beefs = Beef::all();
        $porks = Pork::all();
        $chickens = Chicken::all();
        $veggies = Veggie::all();
        $others = Others::all();
        $foodpacks = Foodpack::all();
        $foodcarts = Foodcart::all();
        $cake = Cake::all();
        $clown = Clown::all();
        $setup = Setup::all();
        $lechon = Lechon::all();
        $facepaint = Facepaint::all();

        // dd($selectedFoodcarts);

        return view('manager.booked-package-edit', compact(
            'packages',
            'package', 
            'customPackage', 
            'customItems',
            'foods', 
            'foodpacks', 
            'foodcarts', 
            'cake', 
            'clown', 
            'setup', 
            'lechon', 
            'facepaint',
            'beefs',
            'porks',
            'chickens',
            'veggies',
            'others',
            'selectedBeef',
            'selectedPork',
            'selectedChicken',
            'selectedVeggie',
            'selectedOther',
            'selectedCake',
            'selectedLechon',
            'selectedClown',
            'selectedFacepaint',
            'selectedSetup',
            'selectedFoodpacks',
            'selectedFoodcarts',
            'fee',
        ));
    }



    public function food()
    {
        return view('manager.custom-food');
    }
    public function foodAdd()
    {
        return view('manager.custom-food-add');
    }
    public function foodView()
    {
        $foods = Food::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-food-view', compact('foods'));
    }
    public function foodEdit(string $food_id)
    {
        $food = Food::find($food_id);
        return view('manager.custom-food-edit')->with("food", $food);
    }

    public function beef()
    {
        return view('manager.custom-beef');
    }
    public function beefAdd()
    {
        return view('manager.custom-beef-add');
    }
    public function beefView()
    {
        $foods = Beef::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-beef-view', compact('foods'));
    }
    public function beefEdit(string $beef_id)
    {
        $food = Beef::find($beef_id);
        return view('manager.custom-beef-edit')->with("food", $food);
    }

    public function pork()
    {
        return view('manager.custom-pork');
    }
    public function porkAdd()
    {
        return view('manager.custom-pork-add');
    }
    public function porkView()
    {
        $foods = Pork::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-pork-view', compact('foods'));
    }
    public function porkEdit(string $pork_id)
    {
        $food = Pork::find($pork_id);
        return view('manager.custom-pork-edit')->with("food", $food);
    }

    public function chicken()
    {
        return view('manager.custom-chicken');
    }
    public function chickenAdd()
    {
        return view('manager.custom-chicken-add');
    }
    public function chickenView()
    {
        $foods = Chicken::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-chicken-view', compact('foods'));
    }
    public function chickenEdit(string $chicken_id)
    {
        $food = Chicken::find($chicken_id);
        return view('manager.custom-chicken-edit')->with("food", $food);
    }

    public function veggie()
    {
        return view('manager.custom-veggie');
    }
    public function veggieAdd()
    {
        return view('manager.custom-veggie-add');
    }
    public function veggieView()
    {
        $foods = Veggie::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-veggie-view', compact('foods'));
    }
    public function veggieEdit(string $veggie_id)
    {
        $food = Veggie::find($veggie_id);
        return view('manager.custom-veggie-edit')->with("food", $food);
    }

    public function other()
    {
        return view('manager.custom-other');
    }
    public function otherAdd()
    {
        return view('manager.custom-other-add');
    }
    public function otherView()
    {
        $foods = Others::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-other-view', compact('foods'));
    }
    public function otherEdit(string $other_id)
    {
        $food = Others::find($other_id);
        return view('manager.custom-other-edit')->with("food", $food);
    }


    public function foodpack()
    {
        return view('manager.custom-foodpack');
    }
    public function foodpackAdd()
    {
        return view('manager.custom-foodpack-add');
    }
    public function foodpackView()
    {
        $foods = Foodpack::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-foodpack-view', compact('foods'));
    }
    public function foodpackEdit(string $foodpack_id)
    {
        $food = Foodpack::find($foodpack_id);
        return view('manager.custom-foodpack-edit')->with("food", $food);
    }


    public function foodcart()
    {
        return view('manager.custom-foodcart');
    }
    public function foodcartAdd()
    {
        return view('manager.custom-foodcart-add');
    }
    public function foodcartView()
    {
        $foodcarts = Foodcart::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-foodcart-view', compact('foodcarts'));
    }
    public function foodcartEdit(string $foodcart_id)
    {
        $food = Foodcart::find($foodcart_id);
        return view('manager.custom-foodcart-edit')->with("food", $food);
    }


    public function lechon()
    {
        return view('manager.custom-lechon');
    }
    public function lechonAdd()
    {
        return view('manager.custom-lechon-add');
    }
    public function lechonView()
    {
        $foods = Lechon::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-lechon-view', compact('foods'));
    }
    public function lechonEdit(string $lechon_id)
    {
        $food = Lechon::find($lechon_id);
        return view('manager.custom-lechon-edit')->with("food", $food);
    }


    public function cake()
    {
        return view('manager.custom-cake');
    }
    public function cakeAdd()
    {
        return view('manager.custom-cake-add');
    }
    public function cakeView()
    {
        $foods = Cake::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-cake-view', compact('foods'));
    }
    public function cakeEdit(string $cake_id)
    {
        $food = Cake::find($cake_id);
        return view('manager.custom-cake-edit')->with("food", $food);
    }


    public function clown()
    {
        return view('manager.custom-clown');
    }
    public function clownAdd()
    {
        return view('manager.custom-clown-add');
    }
    public function clownView()
    {
        $foods = Clown::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-clown-view', compact('foods'));
    }
    public function clownEdit(string $clown_id)
    {
        $food = Clown::find($clown_id);
        return view('manager.custom-clown-edit')->with("food", $food);
    }


    public function setup()
    {
        return view('manager.custom-setup');
    }
    public function setupAdd()
    {
        return view('manager.custom-setup-add');
    }
    public function setupView()
    {
        $foods = Setup::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-setup-view', compact('foods'));
    }
    public function setupEdit(string $setup_id)
    {
        $food = Setup::find($setup_id);
        return view('manager.custom-setup-edit')->with("food", $food);
    }


    public function facepaint()
    {
        return view('manager.custom-facepaint');
    }
    public function facepaintAdd()
    {
        return view('manager.custom-facepaint-add');
    }
    public function facepaintView()
    {
        $foods = Facepaint::orderBy('created_at', 'desc')->paginate(10);
        return view('manager.custom-facepaint-view', compact('foods'));
    }
    public function facepaintEdit(string $facepaint_id)
    {
        $food = Facepaint::find($facepaint_id);
        return view('manager.custom-facepaint-edit')->with("food", $food);
    }
}
