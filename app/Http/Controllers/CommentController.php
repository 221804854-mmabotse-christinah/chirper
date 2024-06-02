<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class CommentController extends Controller
{
    use AuthorizesRequests;
    
    public function store(Request $request, Chirp $chirp)
    {
        $request->validate([
            'body' => 'required|max:255',
        ]);

        $chirp->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('chirps.index');
    }

    public function destroy(Request $request, Comment $comment)
    {
        // Ensure the authenticated user is the owner of the comment
        if ($request->user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the comment
        $comment->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
