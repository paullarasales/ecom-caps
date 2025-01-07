<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Log as Modelslog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
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

    public function pending()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reviews-pending', compact('reviews'));
        // return view('admin.reviews-pending');
    }
    public function approved()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reviews-approved', compact('reviews'));
    }

    public function managerpending()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('manager.reviews-pending', compact('reviews'));
        // return view('admin.reviews-pending');
    }
    public function managerapproved()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('manager.reviews-approved', compact('reviews'));
    }

    public function ownerpending()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.reviews-pending', compact('reviews'));
        // return view('admin.reviews-pending');
    }
    public function ownerapproved()
    {
        $reviews = Review::with(['user', 'appointment']) // Eager load the relationships
            ->where('reviewstatus', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('owner.reviews-approved', compact('reviews'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'images.*' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        // Check if the appointment already has a review
        $existingReview = Review::where('appointment_id', $request->appointment_id)
            ->where('user_id', Auth::id()) // Check for the same user
            ->first();

        if ($existingReview) {
        // return redirect()->back()->with('error', 'You have already submitted a review for this appointment.');
        return redirect()->back()->with([
            'alert' => 'error',
            'message' => 'You have already submitted a review for this appointment.'
        ]);
        }


        // Handle image uploads
        $imageData = [];
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension; // Ensure unique filenames

                $path = "uploads/reviews/";
                $file->move(public_path($path), $filename); // Move the file to the public directory

                $imageData[] = $path . $filename; // Collect image paths
            }
        }

        // Create a new review
        $review = new Review();
        $review->content = $request->content;
        $review->rating = $request->rating;
        $review->reviewimage = $imageData; // Save all image paths as an array
        $review->user_id = Auth::id(); // Assuming the user is logged in
        $review->reviewstatus = "approved";
        $review->appointment_id = $request->appointment_id; // Ensure you pass appointment_id in your form
        $review->save();

        // return redirect()->back()->with('alert', 'Review submitted successfully!');
        return redirect()->route('reviews')->with([
            'alert' => 'success',
            'message' => 'Review submitted successfully!'
        ]);
    }


    public function response(Request $request, $review_id)
    {
        $request->validate([
            'response' => 'required|string'
        ]);

        $review = Review::findOrFail($review_id);

        $review->response = $request->response;
        $review->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Responded';
            $log->description =  $use->firstname . " " . $use->lastname . " Has responded to a client review ";
            $log->logdate = now();
            $log->save();

        $user = $review->user;

            // Create the email content
        $emailContent = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>The Siblings Catering Services responed to your review</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p><strong>Response: </strong>{$review->response}</p>
                    <p>Thank you for choosing The Siblings Catering Services. We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Thank you for choosing our service!</p>
        </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('The Siblings Catering Services responed to your review')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            return redirect()->back()->with([
                'alert' => 'success',
                'message' => 'Event Successfully Booked. However, we could not send a confirmation email at the moment.'
            ]);
        }

        // return redirect()->back()->with('alert', 'Response Submitted successfully!');
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Response Submitted successfully!'
        ]);
    }

    public function managerresponse(Request $request, $review_id)
    {
        $request->validate([
            'response' => 'required|string'
        ]);

        $review = Review::findOrFail($review_id);

        $review->response = $request->response;
        $review->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Event Date Blocked';
            $log->description =  $use->firstname . " " . $use->lastname . " Has responded to a client review ";
            $log->logdate = now();
            $log->save();

            $user = $review->user;

            // Create the email content
        $emailContent = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>The Siblings Catering Services responed to your review</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p><strong>Response: </strong>{$review->response}</p>
                    <p>Thank you for choosing The Siblings Catering Services. We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Thank you for choosing our service!</p>
        </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('The Siblings Catering Services responed to your review')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            return redirect()->route('pending')->with([
                'alert' => 'success',
                'message' => 'Event Successfully Booked. However, we could not send a confirmation email at the moment.'
            ]);
        }

        // return redirect()->back()->with('alert', 'Response Submitted successfully!');
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Response Submitted successfully!'
        ]);

    }

    public function ownerresponse(Request $request, $review_id)
    {
        $request->validate([
            'response' => 'required|string'
        ]);

        $review = Review::findOrFail($review_id);

        $review->response = $request->response;
        $review->save();

        $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Event Date Blocked';
            $log->description =  $use->firstname . " " . $use->lastname . " Has responded to a client review ";
            $log->logdate = now();
            $log->save();

            $user = $review->user;

            // Create the email content
        $emailContent = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>The Siblings Catering Services responed to your review</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p><strong>Response: </strong>{$review->response}</p>
                    <p>Thank you for choosing The Siblings Catering Services. We look forward on making your next event wonderful.</p>
                    <p style='color: #555;'>Thank you for choosing our service!</p>
        </div>
        ";

        try {
            // Send the email
            if (!empty($user->email)) {
                Mail::send([], [], function ($message) use ($user, $emailContent) {
                    $message->to($user->email)
                            ->subject('The Siblings Catering Services responed to your review')
                            ->html($emailContent);
                });
            }
        } catch (\Exception $e) {
            // Log the error or handle it
            Log::error('Email could not be sent: ' . $e->getMessage());
            
            // Redirect back with an error message
            // return redirect()->route('pending')->with('error', 'Failed to send confirmation email.');
            return redirect()->route('pending')->with([
                'alert' => 'success',
                'message' => 'Event Successfully Booked. However, we could not send a confirmation email at the moment.'
            ]);
        }

        // return redirect()->back()->with('alert', 'Response Submitted successfully!');
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'Response Submitted successfully!'
        ]);

    }







    public function statusApproved(Request $request, $review_id)
    {
        // Validate the incoming request if necessary
        $request->validate([
            'status' => 'required|in:approved', // Assuming you only want to accept 'approved'
        ]);

        // Find the review by its ID
        $review = Review::findOrFail($review_id);

        // Update the review's status
        $review->reviewstatus = 'approved';
        $review->save();

        // Optionally, redirect back with a success message
        return redirect()->back()->with('alert', 'Review approved successfully!');
    }
    public function statusPending(Request $request, $review_id)
    {
        // Validate the incoming request if necessary
        $request->validate([
            'status' => 'required|in:pending', // Assuming you only want to accept 'approved'
        ]);

        // Find the review by its ID
        $review = Review::findOrFail($review_id);

        // Update the review's status
        $review->reviewstatus = 'pending';
        $review->save();

        // Optionally, redirect back with a success message
        return redirect()->back()->with('alert', 'Review hidden successfully!');
    }

    public function managerstatusApproved(Request $request, $review_id)
    {
        // Validate the incoming request if necessary
        $request->validate([
            'status' => 'required|in:approved', // Assuming you only want to accept 'approved'
        ]);

        // Find the review by its ID
        $review = Review::findOrFail($review_id);

        // Update the review's status
        $review->reviewstatus = 'approved';
        $review->save();

        // Optionally, redirect back with a success message
        return redirect()->back()->with('alert', 'Review approved successfully!');
    }
    public function managerstatusPending(Request $request, $review_id)
    {
        // Validate the incoming request if necessary
        $request->validate([
            'status' => 'required|in:pending', // Assuming you only want to accept 'approved'
        ]);

        // Find the review by its ID
        $review = Review::findOrFail($review_id);

        // Update the review's status
        $review->reviewstatus = 'pending';
        $review->save();

        // Optionally, redirect back with a success message
        return redirect()->back()->with('alert', 'Review hidden successfully!');
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
