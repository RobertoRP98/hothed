<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaSgi extends Model
{
    use HasFactory;

    protected $table = 'areas_sgi';

    protected $fillable = ['name'];
    
    public function users(){
        return $this->hasMany(UserSgi::class);
    }

    public function documents(){
        return $this->belongsToMany(Document::class, 'document_area','area_id','document_id');
    }

}
