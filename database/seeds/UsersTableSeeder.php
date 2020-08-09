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
        [
            'salutation' =>'Frau',
            'firstname' => 'B.',
            'lastname' => 'Sucher',
            'name_token' => 'besucher',
            'email' => 'be@sucher.de',
            'email_verified_at' => $now,
            'password' => Hash::make('besucher'),
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'salutation' =>'Herr',
            'firstname' => 'Wie',
            'lastname' => 'Aipi',
            'name_token' => 'vip',
            'email' => 'v@ip.de',
            'email_verified_at' => $now,
            'password' => Hash::make('vip'),
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'salutation' =>'Herr',
            'firstname' => 'Joe',
            'lastname' => 'Kher',
            'name_token' => 'joker',
            'email' => 'jo@ker.de',
            'email_verified_at' => $now,
            'password' => Hash::make('joker'),
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
