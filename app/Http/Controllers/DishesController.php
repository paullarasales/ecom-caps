<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.dish");
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
            'dishphoto' => 'required|image|mimes:png,jpg,jpeg,webp',
            'dishname' => 'required',
            'dishcategory' => 'required',
        ]);

        if ($file = $request->file('dishphoto')) {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension; 
        
            $path = "uploads/dish/";
            $file->move(public_path($path), $filename); 
        
            $dish = new Dish();
            $dish->dishname = $request->dishname;
            $dish->dishcategory = $request->dishcategory;
            $dish->user_id = Auth::id();
            $dish->dishphoto = $path . $filename;
            $dish->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Package Created';
            $log->description = $dish->dishname . " package created by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Package added successfully!');
        }

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
