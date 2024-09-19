<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('addfaqs')->with('alert', 'Request Submitted');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $faq_id)
    {
        $faq = Faqs::find($faq_id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();

        return redirect()->route('viewfaqs')->with('alert', 'Faqs Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $faq_id)
    {
        $faq = Faqs::findOrFail($faq_id);

        // Delete the faq from the database
        $faq->delete();

        return redirect()->route('viewfaqs')->with('alert', 'Package deleted successfully!');
    }
}
