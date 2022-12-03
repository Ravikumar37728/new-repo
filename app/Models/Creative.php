<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;
    public $table = "creatives";
    protected $fillable = [
        'name',
        'creative',
        'festival_id',

    ];
    public $dates = [
        'created_at',
        'updated_at',
    ];

    public $casts = ([

        'name' => 'string',
        'creative' => 'string',
        'festival_id' => 'string',

    ]);
}
