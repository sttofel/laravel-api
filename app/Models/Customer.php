<?php

namespace App\Models;

use App\Models\Reseller;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['reseller_id', 'name', 'cnpj'];
    protected $hide = ['reseller_id'];

    // Relacionamento com a revenda
    //public function reseller(){
    //    return $this->belongsTo(Reseller::class);
    //}

    // Relacionamento com computadores
    public function computers()
    {
        return $this->hasMany(Computer::class);
    }


    // Relacionamento com arquivos
    public function files()
    {
        return $this->hasMany(Computer::class);
    }
}
