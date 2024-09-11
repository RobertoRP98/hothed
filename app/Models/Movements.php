<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    public function tool(){
        return $this->belongsTo(Tool::class);
    }

    public function welloil(){
        return $this->belongsTo(Well_oil::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
