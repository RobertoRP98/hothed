<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
       'name',
       'udm',
       'category',
       'precio',
       'taxes_id',
       'discount',
       'min_stock',
       'update_date_price'
    ];

    //Relacion con impuestos
    public function tax(){
        return $this->belongsTo(Tax::class,'taxes_id');
    }

    //Relacion con items de la requisicion
    public function itemsRequisition(){
        return $this->hasMany(ItemRequisition::class, 'product_id');
    }

    //Relación con los items de ordenes de compra

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'product_id');
    }

}
