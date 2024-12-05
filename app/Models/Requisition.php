<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_departament',
        'status_requi',
        'finalizado',
        'importance',
    ];

    //Relacion con usuario
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    //Relacion con items de requisicion 
    public function items(){
        return $this->hasMany(ItemRequisition::class,'requisition_id');
    }

    //Relacion con ordenes de compra 
    public function purchaseOrders(){
        return $this->hasMany(PurchaseOrder::class,'requisition_id');
    }


}
