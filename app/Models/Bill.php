<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyreceivable_id',
        'order_number',
        'bill_number',
        'bill_date',
        'entry_date',
        'expiration_date',
        'description',
        'oil_well',
        'start_operation',
        'end_operation',
        'total_payment',
        'currency', // Nuevo campo
        'status',
        'payment_day',
        'comentary'
    ];
    
    protected $dates = ['bill_date', 'entry_date', 'expiration_date', 'payment_day', 'created_at'];

    protected $table= 'bill';

    protected $guarded = ['id'];

    public function companyReceivable(){

        return $this->belongsTo(CompanyReceivable::class,'companyreceivable_id');
    }

    //metodo para verificar si la factura esta vencida 

    public function isOverdue(){
        return $this->expiration_date < now() && $this->status != 'pagado';
    }

    //metodo para cambiar el estado a pagado y actualizar el campo de fecha de pago 

    public function markAsPaid($paymentDate){
        $this->status ='pagado';
        $this->payment_day = $paymentDate;
        $this->save();
    }



}
