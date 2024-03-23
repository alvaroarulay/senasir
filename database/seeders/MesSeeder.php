<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader('C:/vsiaf/dbfs/mes.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('mes')->insert([
                'mes' => $record->get('mes'),
                'nombres' => $record->get('nommes'), 
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
