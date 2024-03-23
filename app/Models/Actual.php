<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actual extends Model
{
    use HasFactory; 
    protected $table = "actual";
    protected $fillable = [
            'id',
            'codigo',
            'codsec',
            'codarpro',
            'codaux',
            'vidautil',
            'descripcion',
            'costo',
            'codresp',
            'observ',
            'estado',
            'codbien',
            'nroconv',
            'orgfin',
            'usuar',
            'estadoasignacion',
            'incorporacion',
    ];
}
