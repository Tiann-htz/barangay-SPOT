<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Like;
use App\Models\Announcement;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of posts on dashboard.
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes', 'images'])
            ->latest()
            ->get();
            
        $announcements = Announcement::latest()->get();
        
        $chatMessages = ChatMessage::with('user')
            ->latest()
            ->take(100)
            ->get();
        
        return view('dashboard', compact('posts', 'announcements', 'chatMessages'));
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->save();
        
        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('post-images', 'public');
                
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $imagePath
                ]);
            }
        }
        
        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the post.
     */
    public function edit(Post $post)
    {
        // Authorize that only post owner can edit
        $this->authorize('update', $post);
        
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the post.
     */
    public function update(Request $request, Post $post)
    {
        // Authorize that only post owner can update
        $this->authorize('update', $post);
        
        $request->validate([
            'content' => 'required|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:post_images,id',
        ]);

        $post->content = $request->content;
        $post->save();
        
        // Delete selected images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = PostImage::find($imageId);
                if ($image && $image->post_id == $post->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }
        
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('post-images', 'public');
                
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $imagePath
                ]);
            }
        }
        
        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the post.
     */
    public function destroy(Post $post)
    {
        // Authorize that only post owner can delete
        $this->authorize('delete', $post);
        
        // Delete all post images
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the legacy single image if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        
        $post->delete();
        
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
    
    /**
     * Toggle like on a post
     */
    public function toggleLike(Post $post)
    {
        $userId = Auth::id();
        $existing = Like::where('user_id', $userId)
            ->where('post_id', $post->id)
            ->first();
            
        if ($existing) {
            $existing->delete();
            $action = 'unliked';
        } else {
            Like::create([
                'user_id' => $userId,
                'post_id' => $post->id
            ]);
            $action = 'liked';
        }
        
        return back()->with('success', "Post {$action} successfully!");
    }

    

   /**
     * Display trending posts page
     */
    public function trending()
    {
        // Get posts with 3 or more likes
        $trendingPosts = Post::withCount('likes')
            ->with(['user', 'comments.user', 'likes', 'images'])
            ->having('likes_count', '>=', 3)
            ->groupBy('posts.id')
            ->orderBy('likes_count', 'desc')
            ->get();
        
        // Get posts by hashtag categories from the last week
        $lastWeek = Carbon::now()->subWeek();
        $categories = ['barangay cleanup', 'reports', 'events', 'announcements', 'community'];
        $postsByCategory = [];
        
        foreach ($categories as $category) {
            // Search for posts containing the hashtag
            $categoryPosts = Post::withCount('likes')
                ->with(['user', 'comments.user', 'likes', 'images'])
                ->where('created_at', '>=', $lastWeek)
                ->where(function($query) use ($category) {
                    $query->where('content', 'like', "%#{$category}%")
                          ->orWhere('content', 'like', "%#" . str_replace(' ', '', $category) . "%");
                })
                ->groupBy('posts.id') 
                ->orderBy('likes_count', 'desc')
                ->take(5)
                ->get();
            
            if ($categoryPosts->count() > 0) {
                $postsByCategory[$category] = $categoryPosts;
            }
        }
        
        return view('trending', compact('trendingPosts', 'postsByCategory'));
    }
}