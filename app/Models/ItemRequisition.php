<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequisition extends Model
{
    use HasFactory;
    protected $table = 'items_requisition';

    protected $guarded = ['id'];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
