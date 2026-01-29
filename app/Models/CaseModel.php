<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CaseModel extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'cases';

    protected $fillable = [
        'date',
        'new_confirmed',
        'acc_confirmed',
        'acc_negative',
        'positive_rate',
    ];

    protected $casts = [
        'date' => 'datetime',
        'new_confirmed' => 'integer',
        'acc_confirmed' => 'integer',
        'acc_negative' => 'integer',
    ];
}
