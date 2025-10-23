<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Allows mass assignment for these columns
    protected $fillable = ['genreName'];
}
