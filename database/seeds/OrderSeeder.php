<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=6; $i<16; $i++){
            $table = \App\Order::create([
                'menu_id' =>  2,
                'qty' =>  $i,
                'note' =>  'Special more',
                'table_id' =>  $i
            ]);
        }
    }
}