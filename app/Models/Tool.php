<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;
    protected $table = 'tools';

    //relations with well_oil

    public function welloil(){
        return $this->belongsTo(Well_oil::class);
    }

    //relations with clients

    public function client(){
        return $this->belongsTo(Client::class);
    }

    //relations with conditions 
    public function condition(){
        return $this->belongsTo(condition::class);
    }

    //relations with movements 
    public function movements(){
        return $this->hasMany(Movement::class);
    }

    //relations with history
    public function history(){
        return $this->hasMany(Tool_history::class);
    }
}
