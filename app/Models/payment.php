<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    public $fillable=[
        'email',
        'firstname',
        'lastname',
        'phone_no',
        'address',
        'couuntry',
        'city','state','pincode','product_name'
    ];
}
