<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->content = $request->content;
        $comment->save();
        
        return back()->with('success', 'Comment added successfully!');
    }

    /**
     * Update the comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // Authorize that only comment owner can update
        $this->authorize('update', $comment);
        
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->content = $request->content;
        $comment->save();
        
        return back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the comment.
     */
    public function destroy(Comment $comment)
    {
        // Authorize that only comment owner can delete
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return back()->with('success', 'Comment deleted successfully!');
    }
}