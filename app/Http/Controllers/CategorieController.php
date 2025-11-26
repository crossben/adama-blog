<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function getCategories(Request $request)
    {
        try {
            $categories = Categorie::all();

            if ($categories->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Aucune catégorie trouvée'
                ], 404);
            }

            return response()->json([
                'status' => 'ok',
                'categories' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération des catégories'
            ], 500);
        }
    }
}
