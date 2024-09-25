<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
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

    // Registrar el evento de actualización
    protected static function booted()
    {
        static::updated(function ($toolWarehouse) {
            // Obtener los campos cambiados
            $changes = $toolWarehouse->getChanges();

            foreach ($changes as $field => $new_value) {
                // Solo registrar los cambios de los campos que existen en la tabla
                if ($field != 'updated_at') {
                    \App\Models\ToolHistory::create([
                        'toolwarehouse_id' => $toolWarehouse->id,
                        'user_id' => Auth::id(), // El ID del usuario que hizo el cambio
                        'field' => $field,
                        'old_value' => $toolWarehouse->getOriginal($field),
                        'new_value' => $new_value,
                    ]);
                }
            }
        });
    }

}
