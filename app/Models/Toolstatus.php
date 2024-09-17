<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toolstatus extends Model
{
    use HasFactory;
    protected $table='toolstatus';
    protected $guarded = ['id'];
}
