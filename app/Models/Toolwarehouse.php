<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toolwarehouse extends Model
{
    use HasFactory;
    protected $table='toolwarehouse';
    protected $guarded = ['id'];

    public function toolstatus(){
        return $this->belongsTo(Toolstatus::class);
    }

    public function subgroup(){
        return $this->belongsTo(Subgroup::class);
    }
    public function family(){
        return $this->belongsTo(Family::class);
    }
    public function base(){
        return $this->belongsTo(Base::class);
    }
}
