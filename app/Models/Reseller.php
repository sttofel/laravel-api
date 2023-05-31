<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reseller extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['user_id','company_name','document'];
    //protected $hidden = ['updated_at', 'created_at'];

    // Relacionamento com usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relacionamento com clientes
    public function customers(){
        return $this->hasMany(Customer::class);
    }

    // Relacionamento com computadores
    public function computers()
    {
        return $this->hasMany(Computer::class);
    }

}
