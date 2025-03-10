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
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function itemsRequisition()
    {
        return $this->hasMany(ItemRequisition::class);
    }

    public function itemsOrderPurchase()
    {
        return $this->hasMany(ItemOrderPurchase::class);
    }

    public function setAttributesToUppercase(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->attributes[$attribute] = strtoupper($this->attributes[$attribute]);
            }
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setAttributesToUppercase(['internal_id', 'description', 'brand']);
        });
    }
}
