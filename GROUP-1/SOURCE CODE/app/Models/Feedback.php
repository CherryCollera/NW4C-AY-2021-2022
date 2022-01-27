<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

     /**
     * The table this model uses
     *
     * @var string
     */
    protected $table = 'feedbacks';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rater_user_id', 'ratee_user_id', 'post_id',
        'description', 'amount'
    ];
    

}
