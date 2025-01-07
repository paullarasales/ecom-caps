<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerifyIdController extends Controller
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
        return view('admin.edit-verify')->with("user", $user);
    }
    public function manageredit(string $id)
    {
        $user = User::find($id);
        return view('manager.edit-verify')->with("user", $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        // Check if idphoto is null
        if ($user->photo === null) {
            // Do not save the update
            // return redirect("users")->with('alert', 'User ID photo is missing. Update not saved.');
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'User ID photo is missing. Update not saved..'
            ]);
        }

        // If idphoto is not null, proceed with the update
        $user->verifystatus = $request->verifystatus;

        $user->save();

            $use = Auth::user();

            $log = new ModelsLog();
            $log->user_id = Auth::id();
            $log->action = 'Verification';
            $log->description = "A user has been " . $request->verifystatus . " by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();


        // Only send the email if the status is 'verified'
        if ($request->verifystatus === 'verified') {
            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>You have been verified!</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>Thank you for choosing us. Your account verification is complete.</p>
                    <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                        <p>
                            <strong>Details:</strong> <span style='color: #555;'>You are now verified and can make requests.</span><br>
                        </p>
                    </div>
                    <p style='color: #555;'>Thank you for trusting us!</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('You have been verified!')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());

                return redirect()->back()->with([
                    'alert' => 'success',
                    'message' => 'User Successfully Updated. However, we could not send a confirmation email at the moment.'
                ]);
            }
        }

        // return redirect("users")->with('alert', 'User Successfully Updated');
        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'User Successfully Updated.'
        ]);
    }


    public function managerupdate(Request $request, string $id)
    {
        $user = User::find($id);

        // Check if idphoto is null
        if ($user->photo === null) {
            // Do not save the update
            return redirect()->back()->with([
                'alert' => 'error',
                'message' => 'User ID photo is missing. Update not saved..'
            ]);
        }

        // If idphoto is not null, proceed with the update
        $user->verifystatus = $request->verifystatus;

        $user->save();

            $use = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'Verification';
            $log->description = "A user has been " . $request->verifystatus . " by " . $use->firstname . " " . $use->lastname;
            $log->logdate = now();
            $log->save();


        // Only send the email if the status is 'verified'
        if ($request->verifystatus === 'verified') {
            // Create the email content
            $emailContent = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h1 style='color: #333;'>You have been verified!</h1>
                    <p>Dear <strong>{$user->firstname} {$user->lastname}</strong>,</p>
                    <p>Thank you for choosing us. Your account verification is complete.</p>
                    <div style='border: 1px solid #ccc; padding: 15px; border-radius: 5px; background-color: #f9f9f9;'>
                        <p>
                            <strong>Details:</strong> <span style='color: #555;'>You are now verified and can make requests.</span><br>
                        </p>
                    </div>
                    <p style='color: #555;'>Thank you for trusting us!</p>
                </div>
            ";

            try {
                // Send the email
                if (!empty($user->email)) {
                    Mail::send([], [], function ($message) use ($user, $emailContent) {
                        $message->to($user->email)
                                ->subject('You have been verified!')
                                ->html($emailContent);
                    });
                }
            } catch (\Exception $e) {
                // Log the error or handle it
                Log::error('Email could not be sent: ' . $e->getMessage());

                return redirect()->back()->with([
                    'alert' => 'success',
                    'message' => 'User Successfully Updated. However, we could not send a confirmation email at the moment.'
                ]);
            }
        }

        return redirect()->back()->with([
            'alert' => 'success',
            'message' => 'User Successfully Updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
