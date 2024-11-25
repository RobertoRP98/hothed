<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    //Relacion con la orden de compra

    public function purchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id');
    }

    //Relacion con el producto

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
