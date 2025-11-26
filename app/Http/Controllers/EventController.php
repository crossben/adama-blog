<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Assuming you have an Event model

class EventController extends Controller
{
    public function getEvents(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10); // Default to 10 items per page
            $events = Event::where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'status' => 'ok',
                'events' => $events
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération des événements.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEventById($id)
    {
        try {
            $event = Event::where('status', 'publier')->findOrFail($id);

            return response()->json([
                'status' => 'ok',
                'event' => $event
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération de l\'événement.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getRecentEvents()
    {
        try {
            $events = Event::where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No recent events found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'events' => $events
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération des événements récents.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCommingEvents()
    {
        try {
            $events = Event::where('start_date', '>', now())
                ->orderBy('start_date', 'asc')
                ->where('status', 'publier')
                ->take(5)
                ->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No upcoming events found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'events' => $events
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération des événements à venir.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getPastEvents()
    {
        try {
            $events = Event::where('end_date', '<', now())
                ->orderBy('end_date', 'desc')
                ->where('status', 'publier')
                ->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No past events found.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'events' => $events
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération des événements passés.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEventByCategory($categoryId)
    {
        try {
            $events = Event::where('categorie_id', $categoryId)
                ->where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($events->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No events found for this category.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'events' => $events
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Echec de la récupération des événements par catégorie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
