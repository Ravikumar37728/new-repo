<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'name',
        'short_desc',
        'desc',
        'product_image',
        'product_video',
        'price'
    ];
    public $dates = [
        'created_at',
        'updated_at',
    ];
    protected  $casts =[
        'id'=>'string',
        'name'=>'string',
        'short_desc'=>'string',
        'desc'=>'string',
        'product_image'=>'string',
        'product_video'=>'string',
        'price'=>'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    ];


}
