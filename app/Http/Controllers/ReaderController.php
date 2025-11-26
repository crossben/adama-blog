<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReaderController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:readers,email',
                'password' => 'required|string|min:8',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bio' => 'nullable|string|max:1000',
                'phone' => 'nullable|string|max:15',
                'status' => 'nullable|string|in:active,inactive',
            ]);

            $reader = Reader::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'profile_picture' => null, // Will be set after file upload if present
                'bio' => $validatedData['bio'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'status' => $validatedData['status'] ?? 'active',
            ]);

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $reader->profile_picture = 'images/' . $filename;
            }

            // Hash the password
            $reader->password = Hash::make($validatedData['password']);
            $reader->save();
            $token = $reader->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Compte lecteur créé avec succès',
                'reader' => $reader,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création du compte lecteur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            $user = Reader::where('email', $validatedData['email'])->first();

            if ($user && Hash::check($validatedData['password'], $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Connexion réussie',
                    'user' => $user,
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'message' => 'Identifiants invalides'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la connexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ], 200);
    }

    public function updateReader(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'password' => 'sometimes|required|string|min:8|confirmed',
            'profile_picture' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'sometimes|nullable|string|max:1000',
            'phone' => 'sometimes|nullable|string|max:15',
            'status' => 'sometimes|nullable|string|in:active,inactive',
        ]);

        // Find the reader by ID
        $reader = Reader::findOrFail($request->id);

        // Update the reader's information
        if (isset($validatedData['name'])) {
            $reader->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $reader->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $reader->password = bcrypt($validatedData['password']);
        }
        if (isset($validatedData['profile_picture'])) {
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $reader->profile_picture = 'images/' . $filename;
            }
        }
        if (isset($validatedData['bio'])) {
            $reader->bio = $validatedData['bio'];
        }
        if (isset($validatedData['phone'])) {
            $reader->phone = $validatedData['phone'];
        }
        if (isset($validatedData['status'])) {
            $reader->status = $validatedData['status'];
        }

        // Save the updated reader
        $reader->save();

        return response()->json([
            'message' => 'Compte lecteur mis à jour avec succès',
            'reader' => $reader
        ], 200);
    }

    public function deleteReader(Request $request)
    {
        try {
            $user = $request->user();
            // Find the reader by ID

            if ($user->id !== $request->id) {
                return response()->json([
                    'message' => 'Vous n\'êtes pas autorisé à supprimer ce compte'
                ], 403);
            }

            $reader = Reader::findOrFail($request->id);

            // Delete the reader
            $reader->delete();

            return response()->json([
                'message' => 'Lecteur supprimé avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression du lecteur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
