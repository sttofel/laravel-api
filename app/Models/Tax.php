<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory, UuidTrait;

    // Usando UUID
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['version', 'uf', 'filename', 'start', 'end'];

    // Desativando o timestamps, pois este model não precisa
    public $timestamps = false;
}
