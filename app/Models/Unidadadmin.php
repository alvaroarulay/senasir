<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Unidadadmin extends Model
{
    use HasFactory;
    protected $table = "unidadadmin";
    protected $fillable = [
        'entidad',
        'unidad',
        'descrip',
        'ciudad',
        'estado', 
    ];
}
