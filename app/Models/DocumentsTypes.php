<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsTypes extends Model
{
    use HasFactory;

    protected $table = 'documents_types';

     protected $fillable = ['name'];

    public function documents(){
        return $this->hasMany(Document::class);
    }

}
