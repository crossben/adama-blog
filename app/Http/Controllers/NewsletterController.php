<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'is_subscribed' => 'nullable|boolean',
                'language' => 'nullable|string|max:5',
            ]);

            Newsletter::create([
                'email' => $validated['email'],
                'is_subscribed' => $validated['is_subscribed'],
                'language' => $validated['language'] ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Vous vous êtes abonné avec succès à notre newsletter !',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de l\'abonnement à la newsletter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        try {
            $newsletter = Newsletter::where('email', $request->email)->firstOrFail();
            $newsletter->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Vous vous êtes désabonné avec succès de notre newsletter !',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Abonnement non trouvé.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors du désabonnement de la newsletter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
