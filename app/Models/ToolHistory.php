<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToolHistory extends Model
{
    use HasFactory;
    protected $table='tool_histories';
    protected $guarded = ['id'];

    protected $fillable = [
        'toolwarehouse_id',
        'user_id', // Asegúrate de tener este campo aquí
        'field',
        'old_value',
        'new_value',
    ];


    public function user(): BelongsTo
    {
        // Cambiar a belongsTo ya que el historial pertenece a un usuario
        return $this->belongsTo(User::class, 'user_id');
    }
}
