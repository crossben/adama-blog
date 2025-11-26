<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webtv;

class WebtvController extends Controller
{
    public function getWebtvs(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10); // Default to 10 items per page
            $webtvs = Webtv::orderBy('created_at', 'desc')
                ->where('status', 'publier')
                ->paginate($perPage);

            if ($webtvs->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Aucun webtv trouvé.'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'data' => $webtvs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération des webtv.'
            ], 500);
        }
    }

    public function getWebTvById(Request $request)
    {
        try {
            $webtv = Webtv::where('status', 'publier')->findOrFail($request->id);

            return response()->json([
                'status' => 'ok',
                'webtv' => $webtv
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Webtv non trouvé.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération du webtv.'
            ], 500);
        }
    }

    public function getWebTvByCategory(Request $request)
    {
        try {
            $webtvs = Webtv::where('categorie_id', $request->id)
                ->where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($webtvs->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Aucun webtv trouvé pour cette catégorie.'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'webtvs' => $webtvs
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération des webtv par catégorie.'
            ], 500);
        }
    }
}
