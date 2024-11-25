<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'product_id',
        'name',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    //Relacion con requisicion 
    public function requisition(){
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }

    //Relacion con producto
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    
}
