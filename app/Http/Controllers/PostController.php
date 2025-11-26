<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function getPosts(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $posts = Post::with(['categorie', 'comment'])
                ->where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            if ($posts->isEmpty()) {
                return response()->json([
                    'status' => 'not found',
                    'posts' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'posts' => $posts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching posts.'
            ], 500);
        }
    }

    public function getPostById($id)
    {
        try {
            $post = Post::with(['comment'])->where('status', 'publier')->find($id);

            if (!$post) {
                return response()->json([
                    'status' => 'not found',
                    'post' => null,
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'post' => $post,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération du post.'
            ], 500);
        }
    }

    public function getRecentPosts()
    {
        try {
            $posts = Post::where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            if ($posts->isEmpty()) {
                return response()->json([
                    'status' => 'not found',
                    'posts' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'posts' => $posts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching recent posts.'
            ], 500);
        }
    }

    public function getPostByCategory($categoryId)
    {
        try {
            $posts = Post::where('categorie_id', $categoryId)
                ->where('status', 'publier')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($posts->isEmpty()) {
                return response()->json([
                    'status' => 'not found',
                    'posts' => []
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'posts' => $posts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching posts by category.'
            ], 500);
        }
    }
}
