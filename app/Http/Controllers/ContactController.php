<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function storeContact(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'language' => 'nullable|string|max:5',
        ]);

        // Create a new contact entry
        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'language' => $validated['language'] ?? null,
        ]);

        // Response back with a success message
        return response()->json([
            'status' => 'ok',
            'message' => 'Votre message a été envoyé avec succès !'
        ], 201);
    }
}
