<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SectorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('sectors')->insert([
        [
            'name' =>'Automobil- und Fahrzeugbau',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Dienstleistungen',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Informations- und Kommunikationstechnik',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Textil und Mode',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Tourismus und Freizeit',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
