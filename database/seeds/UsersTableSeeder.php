<?php

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
        DB::table('users')->insert([
            'name' => 'Juan dela Cruz',
            'email' => 'juandelacruz@pinoy.com.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'information' => ''
        ]);
    }
}
