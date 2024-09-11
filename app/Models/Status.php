<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table='statuses';

    //relationship with tools
    public function tools(){
        return $this->hasMany(Movement::class);
    }
    //relationship with movements 
    public function movements(){
        return $this->hasMany(Movement::class);
    }
}
