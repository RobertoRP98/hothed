<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisBeta extends Model
{
    use HasFactory;

    protected $table = 'requisbeta';

    protected $fillable = [
        'dep_soli',
        'requisicion', // Asegúrate de tener este campo aquí
        'fecha_requi',
        'prioridad',
        'comentario',
        'orden_compra',
        'fecha_coti',
        'status_oc'
    ];


    protected $guarded = ['id'];



}
