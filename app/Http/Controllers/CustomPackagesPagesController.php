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

class CustomPackagesPagesController extends Controller
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
        return view('admin.packages-new-add-customize', compact(
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
        return view('admin.custom-food');
    }
    public function foodAdd()
    {
        return view('admin.custom-food-add');
    }
    public function foodView()
    {
        $foods = Food::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-food-view', compact('foods'));
    }
    public function foodEdit(string $food_id)
    {
        $food = Food::find($food_id);
        return view('admin.custom-food-edit')->with("food", $food);
    }


    public function foodcart()
    {
        return view('admin.custom-foodcart');
    }
    public function foodcartAdd()
    {
        return view('admin.custom-foodcart-add');
    }
    public function foodcartView()
    {
        $foodcarts = Foodcart::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-foodcart-view', compact('foodcarts'));
    }
    public function foodcartEdit(string $foodcart_id)
    {
        $food = Foodcart::find($foodcart_id);
        return view('admin.custom-foodcart-edit')->with("food", $food);
    }


    public function foodpack()
    {
        return view('admin.custom-foodpack');
    }
    public function foodpackAdd()
    {
        return view('admin.custom-foodpack-add');
    }
    public function foodpackView()
    {
        $foods = Foodpack::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-foodpack-view', compact('foods'));
    }
    public function foodpackEdit(string $foodpack_id)
    {
        $food = Foodpack::find($foodpack_id);
        return view('admin.custom-foodpack-edit')->with("food", $food);
    }

    public function lechon()
    {
        return view('admin.custom-lechon');
    }
    public function lechonAdd()
    {
        return view('admin.custom-lechon-add');
    }
    public function lechonView()
    {
        $foods = Lechon::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-lechon-view', compact('foods'));
    }
    public function lechonEdit(string $lechon_id)
    {
        $food = Lechon::find($lechon_id);
        return view('admin.custom-lechon-edit')->with("food", $food);
    }

    public function cake()
    {
        return view('admin.custom-cake');
    }
    public function cakeAdd()
    {
        return view('admin.custom-cake-add');
    }
    public function cakeView()
    {
        $foods = Cake::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-cake-view', compact('foods'));
    }
    public function cakeEdit(string $cake_id)
    {
        $food = Cake::find($cake_id);
        return view('admin.custom-cake-edit')->with("food", $food);
    }

    public function clown()
    {
        return view('admin.custom-clown');
    }
    public function clownAdd()
    {
        return view('admin.custom-clown-add');
    }
    public function clownView()
    {
        $foods = Clown::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-clown-view', compact('foods'));
    }
    public function clownEdit(string $clown_id)
    {
        $food = Clown::find($clown_id);
        return view('admin.custom-clown-edit')->with("food", $food);
    }

    public function setup()
    {
        return view('admin.custom-setup');
    }
    public function setupAdd()
    {
        return view('admin.custom-setup-add');
    }
    public function setupView()
    {
        $foods = Setup::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-setup-view', compact('foods'));
    }
    public function setupEdit(string $setup_id)
    {
        $food = Setup::find($setup_id);
        return view('admin.custom-setup-edit')->with("food", $food);
    }

    public function facepaint()
    {
        return view('admin.custom-facepaint');
    }
    public function facepaintAdd()
    {
        return view('admin.custom-facepaint-add');
    }
    public function facepaintView()
    {
        $foods = Facepaint::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.custom-facepaint-view', compact('foods'));
    }
    public function facepaintEdit(string $facepaint_id)
    {
        $food = Facepaint::find($facepaint_id);
        return view('admin.custom-facepaint-edit')->with("food", $food);
    }
}
