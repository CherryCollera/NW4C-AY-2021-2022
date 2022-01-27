<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'finished_at', 'post_id', 'convo_id'
    ];

    // Barter and post relationship
    public function post(){
        return $this->belongsTo(Post::class);
    }

}
