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

class OwnerCustomPackagesPagesController extends Controller
{
    public function customadd()
    {
        $foods = Food::all();
        $foodpacks = Foodpack::all();
        $foodcarts = Foodcart::all();
        $cake = Cake::all();
        $clown = Clown::all();
        $setup = Setup::all();
        $lechon = Lechon::all();
        $facepaint = Facepaint::all();
        return view('owner.packages-new-add-customize', compact(
            'foods', 
            'foodpacks', 
            'foodcarts', 
            'cake', 
            'clown', 
            'setup', 
            'lechon', 
            'facepaint'
        ));
    }



    public function food()
    {
        return view('owner.custom-food');
    }
    public function foodAdd()
    {
        return view('owner.custom-food-add');
    }
    public function foodView()
    {
        $foods = Food::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-food-view', compact('foods'));
    }
    public function foodEdit(string $food_id)
    {
        $food = Food::find($food_id);
        return view('owner.custom-food-edit')->with("food", $food);
    }


    public function foodcart()
    {
        return view('owner.custom-foodcart');
    }
    public function foodcartAdd()
    {
        return view('owner.custom-foodcart-add');
    }
    public function foodcartView()
    {
        $foodcarts = Foodcart::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-foodcart-view', compact('foodcarts'));
    }
    public function foodcartEdit(string $foodcart_id)
    {
        $food = Foodcart::find($foodcart_id);
        return view('owner.custom-foodcart-edit')->with("food", $food);
    }


    public function foodpack()
    {
        return view('owner.custom-foodpack');
    }
    public function foodpackAdd()
    {
        return view('owner.custom-foodpack-add');
    }
    public function foodpackView()
    {
        $foods = Foodpack::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-foodpack-view', compact('foods'));
    }
    public function foodpackEdit(string $foodpack_id)
    {
        $food = Foodpack::find($foodpack_id);
        return view('owner.custom-foodpack-edit')->with("food", $food);
    }

    public function lechon()
    {
        return view('owner.custom-lechon');
    }
    public function lechonAdd()
    {
        return view('owner.custom-lechon-add');
    }
    public function lechonView()
    {
        $foods = Lechon::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-lechon-view', compact('foods'));
    }
    public function lechonEdit(string $lechon_id)
    {
        $food = Lechon::find($lechon_id);
        return view('owner.custom-lechon-edit')->with("food", $food);
    }

    public function cake()
    {
        return view('owner.custom-cake');
    }
    public function cakeAdd()
    {
        return view('owner.custom-cake-add');
    }
    public function cakeView()
    {
        $foods = Cake::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-cake-view', compact('foods'));
    }
    public function cakeEdit(string $cake_id)
    {
        $food = Cake::find($cake_id);
        return view('owner.custom-cake-edit')->with("food", $food);
    }

    public function clown()
    {
        return view('owner.custom-clown');
    }
    public function clownAdd()
    {
        return view('owner.custom-clown-add');
    }
    public function clownView()
    {
        $foods = Clown::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-clown-view', compact('foods'));
    }
    public function clownEdit(string $clown_id)
    {
        $food = Clown::find($clown_id);
        return view('owner.custom-clown-edit')->with("food", $food);
    }

    public function setup()
    {
        return view('owner.custom-setup');
    }
    public function setupAdd()
    {
        return view('owner.custom-setup-add');
    }
    public function setupView()
    {
        $foods = Setup::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-setup-view', compact('foods'));
    }
    public function setupEdit(string $setup_id)
    {
        $food = Setup::find($setup_id);
        return view('owner.custom-setup-edit')->with("food", $food);
    }

    public function facepaint()
    {
        return view('owner.custom-facepaint');
    }
    public function facepaintAdd()
    {
        return view('owner.custom-facepaint-add');
    }
    public function facepaintView()
    {
        $foods = Facepaint::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.custom-facepaint-view', compact('foods'));
    }
    public function facepaintEdit(string $facepaint_id)
    {
        $food = Facepaint::find($facepaint_id);
        return view('owner.custom-facepaint-edit')->with("food", $food);
    }
}
