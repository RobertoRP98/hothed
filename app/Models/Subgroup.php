<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subgroup extends Model
{
    use HasFactory;
    protected $table='subgroups';
    protected $guarded = ['id'];

    public function tool(): BelongsTo{
        return $this->belongsTo(Toolwarehouse::class);
    }
}
