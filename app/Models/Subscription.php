<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','first_name','last_name','email','address','counry','state','city','pincode','phone_no'
        ,'product_name','product_price','status', 'cgst','sgst','discount','amount','gst_amount',
            
            
    ];
    protected $dates =[
            'created_at','updated_at',
    ];

    protected $casts=[
            'user_id'=>'string',
            'first_name'=>'string',
            'last_name'=>'string',
            'email'=>'string',
            'address'=>'string',
            'counry'=>'string',
            'state'=>'string',
            'city'=>'string',
            'pincode'=>'string',
            'phone_no'=>'string',
            'product_name'=>'string',
            'product_price'=>'string',
            'status'=>'string',
            'cgst'=>'string',
            'sgst'=>'string',
            'gst'=>'string',
            'discount'=>'string',
            'amount'=>'string',
            'created_at'=>'string',
            'updated_at'=>'string',



    ];
}
