<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool_history extends Model
{
    use HasFactory;
    protected $table = 'tools_history';

    public function tool(){
        return $this->belongsTo(Tool::class);
    }

}
