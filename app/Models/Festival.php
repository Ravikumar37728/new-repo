<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Festival extends Model
{
    use HasFactory;
    public $table = "festivals";
    public $fillable = [
        'name',
        'created_at'
    ];
    public $dates = [
        'created_at',
        'updated_at',
    ];
    public $casts = [
        'name'=>'string',
        'created_at'=>'string',
        'updated_at'=>'string',
    ];
}
