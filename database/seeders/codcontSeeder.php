<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class codcontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    

   
    public function run()
    {
        $table = new TableReader('C:/vsiaf/dbfs/CODCONT.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('codcont')->insert([
            'nombre' => $record->get('nombre'),
            'vidautil' => $record->get('vidautil'),
            'observ' => $record->get('observ'), 
            'depreciar' => $record->get('depreciar'), 
            'actualizar' => $record->get('actualizar'),
            'usuar' => $record->get('usuar'),
            'created_at'=>now(),
            'updated_at'=>now(),
          ]);
        }
    }
}


