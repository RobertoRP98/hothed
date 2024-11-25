<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rfc',
        'contact_number',
        'address',
        'critic',
        'currency',
        'credit_days',
        'single_supplier',
    ];

    //relacion con ordenes de compra
    public function purchaseOrders(){
        return $this->hasMany(PurchaseOrder::class,'supplier_id');
    }
}
