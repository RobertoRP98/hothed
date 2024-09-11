<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Well_oil extends Model
{
    use HasFactory;

    protected $table = 'wells_oil';

    //relationship with tools  
    public function tools(){
        return $this->hasMany(Tool::class);
    }

    public function movements(){
        return $this->hasMany(Movement::class);
    }

}
