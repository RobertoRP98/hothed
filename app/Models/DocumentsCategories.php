<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsCategories extends Model
{
    use HasFactory;

    protected $table = 'documents_categories';

    protected $fillable = ['name'];

    public function documents(){
        return $this->hasMany(Document::class);
    }
}
