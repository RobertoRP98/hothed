<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Well_oil extends Model
{
    use HasFactory;

    protected $table = 'wells_oil';
    protected $guarded = ['id'];
}
