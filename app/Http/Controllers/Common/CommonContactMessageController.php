<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommonContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('common.contact');
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
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:2000',
            ]);
        
            $contact = new ContactMessage();
            $contact->name = $validated['name'];
            $contact->email = $validated['email'];
            $contact->phone = $validated['phone'];
            $contact->subject = $validated['subject'];
            $contact->message = $validated['message'];
            $contact->status = 'new';
            $contact->save();
        
            // Try to send emails (won't fail if mail server not configured)
            try {
                Mail::send('emails.contact-confirmation', ['contact' => $contact], function ($m) use ($contact) {
                    $m->to($contact->email, $contact->name)
                      ->subject('We Received Your Message - RoomMitra');
                });
            } catch (\Exception $e) {
                \Log::warning('Contact confirmation email failed: ' . $e->getMessage());
            }
        
            try {
                Mail::send('emails.contact-notification', ['contact' => $contact], function ($m) use ($contact) {
                    $m->to('developersp741@gmail.com', 'Admin')
                      ->subject('New Contact Message from ' . $contact->name);
                });
            } catch (\Exception $e) {
                \Log::warning('Contact notification email failed: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been received. We will get back to you soon.'
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your input and try again.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
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
