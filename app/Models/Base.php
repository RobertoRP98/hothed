<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Base extends Model
{
    use HasFactory;
    protected $table ='bases';
    protected $guarded = ['id'];

    public function toolwarehouse(): HasMany {
     return $this->hasMany(Toolwarehouse::class, 'base_id'); // Cambiado de 'id' a 'base_id'
 }
 
}
