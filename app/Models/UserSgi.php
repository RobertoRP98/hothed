<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSgi extends Model
{
    use HasFactory;

    protected $table = 'users_sgi';

    protected $fillable = ['name','email','employee_number','workstation_id','immediate_boss_id','area_id','active'];

    public function workstation(){
        return $this->belongsTo(Workstation::class);
    }

    public function area(){
        return $this->belongsTo(AreaSgi::class);
    }

    public function jefeInmediato()
    {
        return $this->belongsTo(UserSgi::class, 'immediate_boss_id');
    }

    public function subordinados(){
        return $this->hasMany(UserSgi::class);
    }
}
