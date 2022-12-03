<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactus extends Model
{
    use HasFactory;
    public $table="contactus";

    protected $fillable=[
        'fullname','messages','email','phone'

    ];
    protected $dates=[
            'created_at','updated_at'
    ];
    protected $casts=[
        'fullname'=>'string',
        'messages'=>'string',
        'email'=>'string',
        'phone'=>'string',
        'created_at'=>'string',
        'updated_at'=>'string',
        ];
}

