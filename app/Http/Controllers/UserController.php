<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Faqs;
use App\Models\Post;
use App\Models\Package;
use App\Models\Appointment;
use App\Models\Blockeddate;
use App\Models\Blockedapp;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

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
        // Fetch booked appointments
        $events = Appointment::where('status', 'booked')->get()->map(function ($event) {
            return [
                'id' => $event->appointment_id,
                'title' => 'Booked',  // Updated title to 'Booked'
                'start' => $event->edate,
                'color' => '#ffc107', // Color for booked events
            ];
        });

        // Fetch blocked dates
        $blockedDates = BlockedDate::all()->map(function ($blocked) {
            return [
                'title' => 'Blocked: ' . ($blocked->reason ? $blocked->reason : 'Unavailable'),
                'start' => $blocked->blocked_date, // Assuming `date` is the field in BlockedDate
                'color' => '#6c757d', // Gray color for blocked dates
                'display' => 'background',  // Set as a background event
                'backgroundColor' => '#1E201E', // Grey fill for blocked dates
                'borderColor' => '#6c757d',  // Optional: No border color (same as fill)
                'allDay' => true,  // Blocked dates are generally full-day events
                'classNames' => ['blocked-event'],
            ];
        });

        // Combine booked events and blocked dates
        $allEvents = $events->merge($blockedDates);

        return response()->json($allEvents);
    }

    public function eventsView()
    {
        return view('client.events');
    }
    public function reviews()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $reviews->avg('rating');

        return view('client.reviews', compact('reviews', 'averageRating'));
    }
    public function makereviews(string $appointment)
    {
        $appointment = Appointment::with(['user', 'package'])
        ->where('status', 'done')
        ->where('appointment_id', $appointment)
        ->first();

        if (!$appointment) {
            return redirect()->route('mydone')->with('error', 'Appointment not found or not pending.');
        }

        return view('client.reviews-make', compact('appointment'));
    }
    public function myevent()
    {
        return view('client.myevent');
    }
    public function myrequest()
    {
        // return view('client.myrequest');
        $user = Auth::user();
        $pendingAppointments = Appointment::with('package')
        ->where('user_id', $user->id)
        ->where('status', 'pending')
        ->get();
        
        return view('client.myrequest', compact('pendingAppointments'));
    }
    public function mybooked()
    {
        // return view('client.myrequest');
        $user = Auth::user();
        $bookedAppointments = Appointment::with('package')
        ->where('user_id', $user->id)
        ->where('status', 'booked')
        ->orderBy('edate', 'desc')
        ->get();
        
        return view('client.mybooked', compact('bookedAppointments'));
    }
    public function mydone()
    {
        // return view('client.myrequest');
        $user = Auth::user();
        $doneAppointments = Appointment::with(['package','review'])
        ->where('user_id', $user->id)
        ->where('status', 'done')
        ->orderBy('edate', 'asc')
        ->get();
        
        return view('client.mydone', compact('doneAppointments'));
    }
    public function chat()
    {
        Message::where('receiver_id', auth()->id())
        ->where('receiverisread', 'unread')
        ->update(['receiverisread' => 'read']);

        // Return the chat view
        return view('client.chat');

        // return view('client.chat');
    }
    public function notifications()
    {
        $user = Auth::user();

        // Check if user has all personal details
        $hasPersonalDetails = $user->firstname && $user->lastname && $user->birthday && 
                            $user->phone && $user->address && $user->city && $user->photo;

        $isVerified = $user->verifystatus === 'verified';

        $appointments = $user->appointment()
                            ->with('review')
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
        $user->appointment()->where('isread', 'unread')->update(['isread' => 'read']);

        // Update `verifyisread` if it's 'unread'
        if ($user->verifyisread === 'unread') {
            $user->verifyisread = 'read';
        }

        // Update `submitisread` if it's 'unread'
        if ($user->submitisread === 'unread') {
            $user->submitisread = 'read';
        }

        // Save the updated user data
        $user->save();

        return view('client.notifications', compact('hasPersonalDetails', 'isVerified', 'appointments'));
    }
    public function book()
    {
        $packages = Package::where('packagename', '!=', 'Custom')
                   ->orderBy('created_at', 'desc')
                   ->paginate(50);
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();
        $blockedApps = Blockedapp::pluck('blocked_app')->toArray(); 

        return view('client.book-form', compact('packages', 'blockedDates', 'blockedApps'));
        // return view('client.book-form');
    }
    public function form()
    {
        // $faqs = Faqs::orderBy('created_at', 'desc')->paginate(30);
        // return view('client.form', compact('faqs'));
        return view('client.form');
    }
    public function meetingform()
    {
        $blockedDates = BlockedDate::pluck('blocked_date')->toArray();
        $blockedApps = Blockedapp::pluck('blocked_app')->toArray(); 
        
        return view('client.form-meeting', compact('blockedDates', 'blockedApps'));
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
            'birthday' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg,webp',
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
