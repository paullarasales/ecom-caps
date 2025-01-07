<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Custom;
use App\Models\Appointment;
use App\Models\Log;

class ClientPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function custom()
    {
        return view('client.custom');
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
            'total_amount' => 'required|numeric',
            'pax' => 'nullable|string', // Pax is a string now
            'pack' => 'nullable|string', // Dropdown
            'cart' => 'nullable|string', // Dropdown
            'cake' => 'nullable|boolean', // Checkbox
            'clown' => 'nullable|string', // Dropdown
            'paint' => 'nullable|boolean', // Checkbox
            'setup' => 'nullable|boolean', // Checkbox
        ]);

        // Custom check for total_amount being 0
        if ($request->total_amount == 0) {
            return back()->withErrors(['total_amount' => 'Total amount cannot be zero.'])->withInput();
        }

        // Initialize inclusions as an empty array
        $inclusions = [];

        // Add valid fields to inclusions array if they are not null
        if ($request->has('pax') && $request->input('pax')) {
            $inclusions[] = $request->input('pax');
        }
        if ($request->has('pack') && $request->input('pack')) {
            $inclusions[] = $request->input('pack');
        }
        if ($request->has('cart') && $request->input('cart')) {
            $inclusions[] = $request->input('cart');
        }
        if ($request->has('clown') && $request->input('clown')) {
            $inclusions[] = $request->input('clown');
        }

        // Add strings for checkboxes if they are checked (i.e., the value is 1)
        if ($request->has('cake') && $request->input('cake') == '1') {
            $inclusions[] = 'Cake';
        }
        if ($request->has('paint') && $request->input('paint') == '1') {
            $inclusions[] = 'Facepaint';
        }
        if ($request->has('setup') && $request->input('setup') == '1') {
            $inclusions[] = 'Setup';
        }

        // Encode inclusions as JSON (this will only include non-null, non-empty values)
        $encodedInclusions = json_encode($inclusions);

        $packageCount = Package::where('user_id', Auth::id())->count();

        // Create the package name based on the user's first name, last name, and package count
        $packageName = Auth::user()->firstname . ' ' . Auth::user()->lastname . ' (' . ($packageCount + 1) . ')';

        // Create a new package record
        $package = new Package();
        $package->packagename = $packageName;
        $package->packagedesc = $request->total_amount; // Assuming package price is used as description
        $package->user_id = Auth::id();
        $package->packageinclusion = $encodedInclusions; // Store inclusions in the database
        $package->packagetype = "Client"; // Or adjust if dynamic
        $package->save();

        // Log the package creation action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Client Package';
        $log->description = $package->packagename . "Package Customize Inclusion created by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->route('book-form')->with('success', 'Package added successfully!');
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
    public function edit(string $package_id)
    {
        // Fetch the package by ID and ensure it belongs to the authenticated user
        $package = Package::where('package_id', $package_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Decode packageinclusion into an associative array
        $inclusions = json_decode($package->packageinclusion, true);

        return view('client.custom-edit', [
            'package' => $package,
            'inclusions' => $inclusions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $package_id)
    {
        // dd($request->all());
        $request->validate([
            'total_amount' => 'required|numeric',
            'pax' => 'nullable|string', // Pax is a string now
            'pack' => 'nullable|string', // Dropdown
            'cart' => 'nullable|string', // Dropdown
            'cake' => 'nullable|boolean', // Checkbox
            'clown' => 'nullable|string', // Dropdown
            'paint' => 'nullable|boolean', // Checkbox
            'setup' => 'nullable|boolean', // Checkbox
        ]);

        // Custom check for total_amount being 0
        if ($request->total_amount == 0) {
            return back()->withErrors(['total_amount' => 'Total amount cannot be zero.'])->withInput();
        }

        // Fetch the package by ID and ensure it belongs to the authenticated user
        $package = Package::where('package_id', $package_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Initialize inclusions as an empty array
        $inclusions = [];

        // Add valid fields to inclusions array if they are not null
        if ($request->has('pax') && $request->input('pax')) {
            $inclusions[] = $request->input('pax');
        }
        if ($request->has('pack') && $request->input('pack')) {
            $inclusions[] = $request->input('pack');
        }
        if ($request->has('cart') && $request->input('cart')) {
            $inclusions[] = $request->input('cart');
        }
        if ($request->has('clown') && $request->input('clown')) {
            $inclusions[] = $request->input('clown');
        }

        // Add strings for checkboxes if they are checked (i.e., the value is 1)
        if ($request->has('cake') && $request->input('cake') == '1') {
            $inclusions[] = 'Cake';
        }
        if ($request->has('paint') && $request->input('paint') == '1') {
            $inclusions[] = 'Facepaint';
        }
        if ($request->has('setup') && $request->input('setup') == '1') {
            $inclusions[] = 'Setup';
        }

        // Encode inclusions as JSON (this will only include non-null, non-empty values)
        $encodedInclusions = json_encode($inclusions);

        // Update package fields
        $package->packagedesc = $request->total_amount; // Update package price/description
        $package->packageinclusion = $encodedInclusions; // Update inclusions
        $package->save();

        // Log the package update action
        $user = Auth::user();
        $log = new Log();
        $log->user_id = Auth::id();
        $log->action = 'Client Package Update';
        $log->description = $package->packagename . " Package Customize Inclusion updated by " . $user->firstname . " " . $user->lastname;
        $log->logdate = now();
        $log->save();

        return redirect()->back()->with('success', 'Package updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
