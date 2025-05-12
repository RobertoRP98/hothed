<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    public function category(){
        return $this->belongsTo(DocumentsCategories::class,'category_id');
    }

    public function revisor(){
        return $this->belongsTo(UserSgi::class, 'revisor_id');
    }

    public function aprobador(){
        return $this->belongsTo(UserSgi::class,'aprobador_id');
    }

    public function areaResponsable(){
        return $this->belongsTo(AreaSgi::class,'area_resp_id');
    }

    public function history(){
        return $this->hasMany(HistoryDocument::class,'document_id');
    }

    public function users(){
        return $this->belongsToMany(UserSgi::class,'document_user','document_id','user_id');
    }

    public function areas(){
        return $this->belongsToMany(AreaSgi::class,'document_area','document_id','area_id');
    }

}
