<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Students extends Model
{
    protected $connection  = 'mongodb';
    protected $table = 'Students';
}
