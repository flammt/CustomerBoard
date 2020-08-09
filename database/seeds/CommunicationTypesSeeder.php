<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CommunicationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('communication_types')->insert([
        [
            'name' =>'Telefonisch',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Email',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Persönlich beim Kunden',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Kunde im Haus',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
