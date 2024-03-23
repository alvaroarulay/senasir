<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;

class BajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader('C:/vsiaf/dbfs/baja.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('baja')->insert([
                'codbaja' => $record->get('codbaja'),
                'descbaja' => $record->get('descbaja'), 
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
