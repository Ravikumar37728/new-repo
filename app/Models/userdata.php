<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userdata extends Model
{
    use HasFactory;
    public $table= "userdata";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phoneno',
        'payment_status',
        'product_name'
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        
        'id' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'phoneno' => 'string',
        'payment_status' => 'string',
        'product_name'=>'string',
    ];

}