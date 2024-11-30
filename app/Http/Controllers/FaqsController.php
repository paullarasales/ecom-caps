<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class FaqsController extends Controller
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
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $appointment = new Faqs($request->all());
        $appointment->user_id = Auth::id(); // Set the user ID from the authenticated user
        $appointment->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Created';
            $log->description = "new FAQs created by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Uploaded successfully!');
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
    public function edit(string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        return view('admin.faqs-edit')->with("faq", $faq);
    }
    public function owneredit(string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        return view('owner.faqs-edit')->with("faq", $faq);
    }
    public function manageredit(string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        return view('manager.faqs-edit')->with("faq", $faq);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Updated';
            $log->description = "FAQs updated by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }
    public function ownerupdate(Request $request, string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Updated';
            $log->description = "FAQs updated by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }
    public function managerupdate(Request $request, string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Updated';
            $log->description = "FAQs updated by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

            return redirect()->back()->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $faq_id)
    {
        $faq = Faqs::findOrFail($faq_id);

        // Delete the faq from the database
        $faq->delete();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Deleted';
            $log->description = "FAQs Deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('viewfaqs')->with('success', 'Deleted successfully!');
    }
    public function ownerdestroy(string $faq_id)
    {
        $faq = Faqs::findOrFail($faq_id);

        // Delete the faq from the database
        $faq->delete();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Deleted';
            $log->description = "FAQs Deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('ownerviewfaqs')->with('success', 'Deleted successfully!');
    }
    public function managerdestroy(string $faq_id)
    {
        $faq = Faqs::findOrFail($faq_id);

        // Delete the faq from the database
        $faq->delete();

            $user = Auth::user();

            $log = new Log();
            $log->user_id = Auth::id();
            $log->action = 'FAQs Deleted';
            $log->description = "FAQs Deleted by " . $user->firstname . " " . $user->lastname;
            $log->logdate = now();
            $log->save();

        return redirect()->route('managerviewfaqs')->with('alert', 'Faqs deleted successfully!');
    }
}
