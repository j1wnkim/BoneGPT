<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Study;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class PublicController extends Controller
{
    public function home() {
        return view('home');
    }

	public function about() {
		return view('about');
	}

	public function coreFacility()
	{
		return view('core-facility');
	}

	public function dataSubmission()
	{
		$studies = Auth::check() ? Auth::user()->studies : collect();
		return view('data-submission', compact('studies'));
	}

	public function contact()
	{
		return view('contact');
	}

	 // Handle the contact form submission
	 public function submitContact(Request $request)
	 {
		 // Validate the form input
		 $request->validate([
			 'name' => 'required|string|max:255',
			 'email' => 'required|email',
			 'subject' => 'required|string|max:255',
			 'message' => 'required|string',
		 ]);
 
		 // Prepare email data
		 $data = [
			 'name' => $request->name,
			 'email' => $request->email,
			 'subject' => $request->subject,
			 'messageBody' => $request->message,
		 ];
 
		 // Send email
		 Mail::send('emails.contact', $data, function ($message) use ($request) {
			 $message->to('rossa@uchc.edu')
					 ->subject($request->subject)
					 ->replyTo($request->email);
		 });
 
		 // Redirect back with success message
		 return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
	 }

	}
	
