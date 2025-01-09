<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;
    protected $table = 'requisitions';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemsRequisition()
    {
        return $this->hasMany(ItemRequisition::class, 'requisition_id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    protected static function boot(){

        parent::boot();

        static::saving(function ($requisition) {
            $daysRemaining = $requisition->days_remaining;

            if ($daysRemaining <= 15) {
                $requisition->importance = 'Critico';
            } elseif ($daysRemaining <= 30) {
                $requisition->importance = 'Alta';
            } elseif ($daysRemaining <= 60) {
                $requisition->importance = 'Media';
            } else {
                $requisition->importance = 'Baja';
            }
        });
    }
}
