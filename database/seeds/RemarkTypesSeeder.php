<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RemarkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        DB::table('remark_types')->insert([
        [
            'name' =>'Bemerkung',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Notiz',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'name' =>'Typ',
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ]
        );
    }
}
