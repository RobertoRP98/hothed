<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDocument extends Model
{
    use HasFactory;

    protected $table = 'history_documents';

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
}
