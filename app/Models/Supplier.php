<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $guarded = ['id'];

    protected $fillable = [
        'name', 'rfc', 'number', 'address', 'critic', 'currency', 'credit_days', 'unique', 'email','account'
    ];

    


    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
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
            $model->setAttributesToUppercase(['name','rfc','address','account']);
        });
    }
}
