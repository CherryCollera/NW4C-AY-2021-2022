<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'convo_id', 'post_id',
        'content', 'image_path', 'is_read',
        'offer_id'
    ];

     // Conversation and Message Relationship
     public function conversation(){
        return $this->belongsTo(Conversation::class);
    }
}
