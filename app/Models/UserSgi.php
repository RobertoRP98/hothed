<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSgi extends Model
{
    use HasFactory;

    protected $table = 'users_sgi';

    public function workstation(){
        return $this->belongsTo(Workstation::class);
    }

    public function area(){
        return $this->belongsTo(AreaSgi::class);
    }

    public function jefeInmediato(){
        return $this->belongsTo(UserSgi::class);
    }

    public function subordinados(){
        return $this->hasMany(UserSgi::class);
    }
}
