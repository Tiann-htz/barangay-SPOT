<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $announcements = Announcement::where('user_id', Auth::id())
                            ->latest()
                            ->get();
        $chatMessages = ChatMessage::with('user')
                            ->latest()
                            ->take(100)
                            ->get();
        return view('admin.dashboard', compact('announcements', 'chatMessages'));
    }
    
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image_path'] = $imagePath;
        }
        
        Announcement::create($data);
        
        return redirect()->back()->with('status', 'Announcement posted successfully!');
    }
    
    public function editAnnouncement(Announcement $announcement): View
    {
        $this->authorize('update', $announcement);
        return view('admin.edit-announcement', compact('announcement'));
    }
    
    public function updateAnnouncement(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            
            $imagePath = $request->file('image')->store('announcements', 'public');
            $data['image_path'] = $imagePath;
        }
        
        $announcement->update($data);
        
        return redirect()->route('admin.dashboard')->with('status', 'Announcement updated successfully!');
    }
    
    public function destroyAnnouncement(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);
        
        // Delete image if exists
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }
        
        $announcement->delete();
        
        return redirect()->route('admin.dashboard')->with('status', 'Announcement deleted successfully!');
    }
}