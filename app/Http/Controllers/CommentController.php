<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'post_id' => 'required|integer|exists:posts,id',
            'reader_id' => 'required|integer|exists:readers,id',
            'content' => 'required|string|max:255',
        ]);

        // Create a new comment entry
        Comment::create([
            'post_id' => $validated['post_id'],
            'reader_id' => $validated['reader_id'],
            'content' => $validated['content'],
        ]);

        // Response back with a success message
        return response()->json([
            'status' => 'ok',
            'message' => 'Your comment has been added successfully!'
        ], 201);
    }

    public function deleteComment(Request $request)
    {
        // Validate the comment ID
        $user = $request->user();

        $comment = Comment::find($request->id);
        if (!$comment) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Commentaire non trouvé'
            ], 404);
        }

        if ($user->id !== $comment->reader_id) {
            return response()->json([
                'status' => 'forbidden',
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire'
            ], 403);
        }

        // Delete the comment
        $comment->delete();

        // Response back with a success message
        return response()->json([
            'status' => 'ok',
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}
