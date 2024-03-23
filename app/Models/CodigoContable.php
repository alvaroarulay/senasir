<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unidadadmin;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class CodigoContable extends Model
{
    use HasFactory;
    protected $table = "codcont";
    protected $fillable = [
        'unidad',
        'nombre',
        'vidautil',
        'observ', 
        'depreciar', 
        'actualizar', 
        'usuar',

    ];
    public function auxiliares()
    {
        return $this->hasMany('App\Auxiliares');
    }
}           
