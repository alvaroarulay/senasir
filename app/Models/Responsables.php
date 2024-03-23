<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsables extends Model
{
    use HasFactory;
    protected $table = "resp";
    protected $fillable = [
        'id',
        'unidad',
        'codresp',
        'nomresp',
        'cargo',
        'observ',
        'ci',
        'usuar',
        'estado',
        'inicio',
        'fin',
    ];
}
