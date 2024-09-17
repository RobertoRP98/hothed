<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typemaint extends Model
{
    use HasFactory;
    protected $table = 'type_maint';
    protected $guarded = ['id'];

}
