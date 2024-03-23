<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Oficinas extends Model
{
    use HasFactory;
    protected $table = "oficina";
    protected $fillable = [
        'unidad',
        'nomofic',
        'observ',
        'usuar',
        'estado',
    ];
    
}
