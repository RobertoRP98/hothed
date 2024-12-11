<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $guarded = ['id'];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function itemsRequisition()
    {
        return $this->hasMany(ItemRequisition::class);
    }

    public function itemsOrderPurchase()
    {
        return $this->hasMany(ItemOrderPurchase::class);
    }
}
