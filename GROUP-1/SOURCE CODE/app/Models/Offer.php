<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id', 'prod_name',
        'prod_qty', 'qty_type', 'date_produced',
        'date_expiree', 'category', 'est_price',
        'status'
    ];
}
