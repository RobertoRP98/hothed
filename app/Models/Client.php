<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';

    //relationship with tools
    public function tools(){
        return $this->hasMany(Tool::class);
    }

    //relationship with movements
    public function movements(){
        return $this->hasMany(Movement::class);
    }
}
