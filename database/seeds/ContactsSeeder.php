<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = ["", "", "Dr.", "", "", "Dr.", "", "Prof."];
        $vornamen = ["Emilia", "Laura", "Sarah", "Lina", "Ella", "Anna", "Ida", "Leonie", "Elias", "Emil", "Liam", "Theo", "Felix", "Paul", "Anton", "Jonas", "Linus", "Markus",
            "Klaus-Peter", "Hans-Jürgen", "Jan-Heinrich", "Maria-Magdalena", "Maria-Theresia", "Rosa-Viktoria"];
        $nachnamen = ["Müller", "Schmidt", "Schneider", "Fischer", "Weber", "Mayer", "Wagner", "Becker", "Schulz", "Hoffmann", "Zimmermann", "Schuhmacher", "Becker-Schulz",
            "Schulz-Hoffmann"];
        $genders = ["m", "w"];
        $abteilungen = ["Verkauf", "Geschäftsleitung", "Einkauf", "Personal", "Produktion", "Vorstand", "IT", "Service"];
        $positionen = ["Abteilungsleiterin", "Geschäftsführer", "Personalreferentin", "Vorsitzender", "Verkaufer", "Softwareentwickler", "Mitarbeiter"];
        $now = \Carbon\Carbon::now();
        for ($i = 1; $i < 101; $i++) {
            DB::table('contacts')->insert([
                'account_id' => $i,
                'title' => $titles[rand(0, 7)],
                'firstname' => $vornamen[rand(0, 23)],
                'lastname' => $nachnamen[rand(0, 13)],
                'gender' => $genders[rand(0, 1)],
                'department' => $abteilungen[rand(0, 7)],
                'position' => $positionen[rand(0, 6)],
                'is_adhoc' => boolval(rand(0, 1)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('contacts')->insert([
                'account_id' => $i,
                'title' => $titles[rand(0, 7)],
                'firstname' => $vornamen[rand(0, 23)],
                'lastname' => $nachnamen[rand(0, 13)],
                'gender' => $genders[rand(0, 1)],
                'department' => $abteilungen[rand(0, 7)],
                'position' => $positionen[rand(0, 6)],
                'is_adhoc' => boolval(rand(0, 1)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('contacts')->insert([
                'account_id' => $i,
                'title' => $titles[rand(0, 7)],
                'firstname' => $vornamen[rand(0, 23)],
                'lastname' => $nachnamen[rand(0, 13)],
                'gender' => $genders[rand(0, 1)],
                'department' => $abteilungen[rand(0, 7)],
                'position' => $positionen[rand(0, 6)],
                'is_adhoc' => boolval(rand(0, 1)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
