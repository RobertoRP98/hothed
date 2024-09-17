<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Toolwarehouse extends Model
{
    use HasFactory;
    protected $table='toolwarehouse';
    protected $guarded = ['id'];


    public function family(): HasOne{
        return $this->hasOne(Family::class);
    }

    public function subgroup(): HasOne{
        return $this->hasOne(Subgroup::class);
    }

    public function base(): HasOne{
        return $this->hasOne(Base::class);
    }

    public function status(): HasOne{
        return $this->hasOne(Status::class);
    }

}
