<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use XBase\TableReader;
use Illuminate\Support\Facades\DB;
class AuxiliarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new TableReader('C:/vsiaf/dbfs/auxiliar.dbf',['encoding' => 'cp1251']);
        while ($record = $table->nextRecord()) {
            DB::table('auxiliar')->insert([
                'codcont' => $record->get('codcont'),
                'codaux' => $record->get('codaux'),
                'nomaux' => $record->get('nomaux'),
                'observ' => $record->get('observ'),
                'usuar' => $record->get('usuar'),
                'created_at'=>now(),
                'updated_at'=>now(),
          ]);
        }
    }
}
