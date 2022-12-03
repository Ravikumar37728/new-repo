<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vacancy extends Model
{
    use HasFactory;
    public $table = "vacancy";
    protected $fillable = [
        'id',
        'position',
        'description',
        'vacancy',
        'experience',

    ];
    public $dates = [
        'created_at',
        'updated_at',
    ];
    protected  $casts = [
        'id' => 'string',
        'position' => 'string',
        'description' => 'string',
        'vacancy' => 'string',
        'experience' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    ];
}
