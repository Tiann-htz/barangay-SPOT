<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_message_id',
        'image_path',
    ];

    /**
     * Get the chat message that owns the image.
     */
    public function chatMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class);
    }
}