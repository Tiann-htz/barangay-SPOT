<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChatMessageController extends Controller
{
    /**
     * Display all chat messages.
     */
    public function index(): View
    {
        $chatMessages = ChatMessage::with('user')->latest()->get();
        
        return view('chat.index', compact('chatMessages'));
    }

    /**
     * Store a new chat message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully!');
    }

    /**
     * Show the form for editing the message.
     */
    public function edit(ChatMessage $chatMessage): View
    {
        $this->authorize('update', $chatMessage);
        
        return view('chat.edit', compact('chatMessage'));
    }

    /**
     * Update the message.
     */
    public function update(Request $request, ChatMessage $chatMessage)
    {
        $this->authorize('update', $chatMessage);
        
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $chatMessage->update([
            'message' => $request->message,
        ]);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('status', 'Message updated successfully!');
        }
        
        return redirect()->route('dashboard')->with('success', 'Message updated successfully!');
    }

    /**
     * Delete the message.
     */
    public function destroy(ChatMessage $chatMessage)
    {
        $this->authorize('delete', $chatMessage);
        
        $chatMessage->delete();
        
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('status', 'Message deleted successfully!');
        }
        
        return redirect()->route('dashboard')->with('success', 'Message deleted successfully!');
    }
}