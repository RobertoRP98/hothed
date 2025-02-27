<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subgroup extends Model
{
    use HasFactory;
    protected $table='subgroups';
    protected $guarded = ['id'];

    public function toolwarehouse(): HasMany {
        return $this->hasMany(Toolwarehouse::class, 'subgroup_id'); // Cambiado de 'id' a 'subgroup_id'
    }
    

}
