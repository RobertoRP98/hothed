<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $table = 'taxes';

    protected $fillable = [
        'name',
        'percent'
    ];

    //Relación con productos
    public function products(){
        return $this->hasMany(Product::class, 'taxes_id');
    }

    //Relación con ordenes de compra

    Public function purchaseOrders(){
        return $this->hasMany(PurchaseOrder::class,'taxes_id');
    }

   
}
