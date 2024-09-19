<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Faqs;
use App\Models\Post;
use App\Models\Package;
use App\Models\Appointment;

class UserController extends Controller
{
    public function dashboard()
    {
        $post = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('client.dashboard', compact('post'));
    }
    public function aboutus()
    {
        return view('client.aboutus');
    }
    public function faqs()
    {
        $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        return view('client.faqs', compact('faqs'));
    }
    public function events()
    {
        $events = Appointment::where('status', 'booked')
        ->get()
        ->map(function ($event) {
            $color = '#ffc107';
            return [
                'id' => $event->appointment_id,
                'title' => $event->type,
                'start' => $event->edate,
                'color' => $color,
            ];
        });
    
        return response()->json($events);
    }
    public function eventsView()
    {
        return view('client.events');
    }
    public function reviews()
    {
        return view('client.reviews');
    }
    public function chat()
    {
        return view('client.chat');
    }
    public function book()
    {
        $packages = Package::orderBy('created_at', 'desc')->paginate(30);
        return view('client.book-form', compact('packages'));
        // return view('client.book-form');
    }
    public function form()
    {
        // $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        // return view('client.form', compact('faqs'));
        return view('client.form');
    }
    public function idverify()
    {
        return view('client.edit-verify');
    }
    public function personal($id) {
        $user = User::findOrFail($id); // Find the user by ID
        return view('client.personal', compact('user'));
    }
    public function update(Request $request, string $id) {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'photo' => 'nullable|mimes:png,jpg,jpeg,webp',
        ]);
    
        $user = User::findOrFail($id);
        
        // Update user details
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/category/';
            $file->move($path, $filename);
            $user->photo = $path . $filename;
        }
    
        $user->save();
    
        return redirect()->route('dashboard')->with('alert', 'Request for verification is submitted, wait for verification before you can request for appointmenrt');
    }
}
