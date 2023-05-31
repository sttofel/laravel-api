<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['reseller_id', 'customer_id', 'serial', 'start_date', 'end_date', 'review'];
    protected $hide = ['reseller_id', 'customer_id'];

    // Relacionamento com clientes
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relacionamento com revenda
    public function reseller(){
       return $this->belongsTo(Reseller::class);
    }
}
