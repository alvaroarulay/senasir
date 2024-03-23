<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class Auxiliares extends Model
{
    use HasFactory;
    protected $table = "auxiliar";
    protected $fillable = [
        'codcont',
        'nomaux',
        'observ',
        'feult',
        'usuar',
    ];
    public function codcont(){
        return $this->belongsTo('App\CodigoContable');
    }
}
