<?php

use App\Table;
use Illuminate\Database\Seeder;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=3; $i<6; $i++){
            $table = Table::create([
                'table_no' =>  $i,
                'table_name' =>  'Table '.$i,
                'mode' =>  'FREE',
                'status' =>  1,
            ]);
        }
        for($i=6; $i<11; $i++){
            $table = Table::create([
                'table_no' =>  $i,
                'table_name' =>  'Table '.$i,
                'mode' =>  'BUSY',
                'status' =>  1,
            ]);
        }
        for($i=11; $i<16; $i++){
            $table = Table::create([
                'table_no' =>  $i,
                'table_name' =>  'Table '.$i,
                'mode' =>  'WAITING',
                'status' =>  1,
            ]);
        }
    }
}
