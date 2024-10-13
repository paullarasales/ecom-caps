<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsertypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::orderBy('created_at', 'desc')->paginate(5);
        // return view('admin.users', compact('users'));
        

        $search = $request->input('search');

    // If a search query exists, filter users based on name or usertype
    $users = User::when($search, function ($query, $search) {
        return $query->where('firstname', 'like', "%{$search}%")
        ->orWhere('lastname', 'like', "%{$search}%")
        ->orWhereRaw("CONCAT(firstname, ' ', lastname) like ?", ["%{$search}%"]);
    })
    ->orderBy('created_at', 'desc')
    ->whereIn('usertype', ['manager', 'user', 'owner'])
    ->paginate(10);

    return view('admin.users', compact('users', 'search'));
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
        //
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
        $user = User::find($id);
        return view('admin.usertype-edit')->with("user", $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->usertype = $request->usertype;
        $user->save();

        return redirect("users")->with('alert', 'User Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
