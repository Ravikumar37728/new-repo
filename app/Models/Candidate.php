<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SspfTrait;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'resume',
        'work_experience',
        'current_ctc',
        'location',
        'messages',
        'address'
        
    ];
    public $dates = [
        'created_at',
        'updated_at',
    ];
    protected  $casts =[
        'id'=>'string',
        'first name'=>'string',
        'last name'=>'string',
        'email'=>'string',
        'phone'=>'string',
        'resume'=>'string',
        'created_at'=>'string',
        'updated_at'=>'string'
    ];
  
    
}
