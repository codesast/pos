<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id' => '1',
            'name' => 'Admin',
            'username' => 'superuser',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Pokhara1'),
            'role' => 'admin',
        ]);
    }
}
