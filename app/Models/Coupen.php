<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupen extends Model
{
        use HasFactory;

        public $fillable = ([

                        'code',
                        'price',
                        'status',
                        'product',
                        'duration'
                ]
        );


        public $dates = [
                'created_at',
                'updated_at',
        ];

        public $casts = ([

                'code' => 'string',
                'price' => 'string',
                'duration' => 'string',
        ]);
}
