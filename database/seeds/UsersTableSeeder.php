<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('users')->insert([
        [
            'salutation' =>'Herr',
            'firstname' => 'admin',
            'lastname' => 'admin',
            'name_token' => 'admin',
            'email' => 'admin@server.de',
            'email_verified_at' => $now,
            'password' => Hash::make('passwort'),
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
