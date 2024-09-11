<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    protected $table = 'conditions';
    //relationship with toools()
    public function tools(){
        return $this->hasMany(Tool::class);
    }

    //relationship with movements 
    public function movements(){
        return $this->hasMany(Movement::class);
    }
}
