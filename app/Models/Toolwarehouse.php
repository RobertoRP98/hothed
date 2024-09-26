<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function histories(){
    return $this->hasMany(ToolHistory::class);
    }

    protected $fillable = [
        'family_id',
        'subgroup_id',
        'description',
        'serienum',
        'extdia',
        'guidia',
        'insdia',
        'fishingneck',
        'conpin',
        'conbox',
        'opera',
        'length',
        'necklength',
        'lastinsp',
        'datelastinsp',
        'outfolio',
        'departuredate',
        'toolstatus_id',
        'comentary',
        'intloca',
        'QR',
        'base_id'
    ];
}