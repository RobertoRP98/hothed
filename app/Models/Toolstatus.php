<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Toolstatus extends Model
{
    use HasFactory;
    protected $table='toolstatus';
    protected $guarded = ['id'];

    public function toolwarehouse(): HasMany{
        return $this->hasMany(Toolwarehouse::class, 'id');
    }
}
