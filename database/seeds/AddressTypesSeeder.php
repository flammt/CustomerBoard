<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddressTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('address_types')->insert([
        [
            'name' =>'Hauptaddresse',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Zweigstelle',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Niederlassung',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
