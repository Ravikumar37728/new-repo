<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public $table ="invoices";
    protected $fillable=[
        'user_id','user_name','user_email','user_address','user_country_name','user_state_name	','user_city_name','user_pincode','user_phone'
        ,'plan_name','plan_amount','cgst_amount','sgst_amount','discount','total_amount','gst_amount','invoice_no',
            
    ];
    protected $dates =[
            'created_at','updated_at',
    ];

    protected $casts=[
            'user_id'=>'string',
            'user_name'=>'string',
            'last_name'=>'string',
            'user_email'=>'string',
            'user_address'=>'string',
            'user_country_name'=>'string',
            'user_state_name	'=>'string',
            'city'=>'string',
            'user_pincode'=>'string',
            'user_phone'=>'string',
            'plan_name'=>'string',
            'plan_amount'=>'string',
            'cgst_amount'=>'string',
            'sgst_amount'=>'string',
            'gst_amount'=>'string',
            'discount'=>'string',
            'total_amount'=>'string',
            'invoice_no'=>  'string',
            'created_at'=>'string',
            'updated_at'=>'string',



    ];

}
