<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyReceivable extends Model
{
    use HasFactory;

    protected $table = 'companyreceivable';
    protected $guarded = ['id'];

    public function bills(){
        return $this->hasMany(Bill::class, 'companyreceivable_id');
    }

}
