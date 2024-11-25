<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'supplier_id',
        'type_po',
        'date_start',
        'date_end',
        'status_time',
        'status_manager1',
        'status_manager2',
        'status_manager3',
        'status_manager4',
        'po_importance',
        'currency',
        'total',
        'subtotal',
        'taxes_id',
        'po_status',
        'bill',
        'finalizado'
    ];

    //relacion con requisicion
    public function requisition(){
        return $this->belongsTo(Requisition::class,'requisition_id');
    }

    //Relacion con proveedor

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    //relacion con impuestos

    public function tax(){
        return $this->belongsTo(Tax::class, 'taxes_id');
    }

    //Relacion con items de la orden
    public function items(){
        return $this->hasMany(OrderItem::class, 'purchase_order_id');
    }
}
