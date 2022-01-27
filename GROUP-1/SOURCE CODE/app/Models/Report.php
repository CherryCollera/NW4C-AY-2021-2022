<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'reported_post_id', 'reported_user_id',
        'description', 'report_type', 'action_taken',
        'mod_assigned', 'is_resolved', 'mod_notes',
        'offense_level',
    ];
}
