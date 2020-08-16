<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ConnectionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('connectiontypes')->insert([
        [
            'name' =>'Email',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Mobil',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Festnetz',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
