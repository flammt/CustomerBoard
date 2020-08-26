<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RemarksSeeder extends Seeder
{

    private $remarks = [
        "Zieht den linken Schuh zuerst an.",
        "Zieht den rechten Schuh zuerst an.",
        "Putzt sich mit beiden Händen die Zähne.",
        "Macht Morgengymnastik.",
        "Hat manchmal den Pullover falsch herum an.",
        "Trinkt das Salatdressing direkt aus der Schale!",
        "Kratzt sich oft am Kopf.",
        "Blinzelt oft.",
        "Redet mit tieferer Stimme als sie eigentlich ist.",
        "Redet mit höherer Stimme als sie eigentlich ist.",
        "Föhnt sich die Glatze.",
        "Geht öfter mal zum Psychotherapeuten.",
        "Hat einen exzentrischen Geschmack.",
        "Spricht manchmal Sätze nicht zu Ende.",
        "Macht gerne den Pausenclown.",
        "Ist häufig unrasiert.",
        "Kann nicht gut auf hohen Absätzen laufen.",
        "Geht sich in der Pause nachschminken.",
        "Nascht häufig Süßes.",
        "Nascht häufig Salziges.",
        "Kommt in schlappen zur Arbeit!",
        "Hat die Hosenbeine zu kurz!",
        "Trägt ein aufdringliches Parfüm!",
        "Trägt ein dezentes Parfüm.",
        "Hockt in der Pause immer alleine rum und spielt Spiele auf dem Handy.",
        "Weigert sich wehement, nach der Arbeit noch einen Trinken zu gehen und verschwindet ganz schnell, damit man sie nicht fragen kann!",
        "Redet die ganze zeit und lässt einen nicht zu Wort kommen.",
        "Gibt immer Süßigkeiten und Snacks aus!",
    ];

    private $addressRemarks = [
        "Tor steht immer offen!",
        "Keine Parkplätze!",
        "Empfang meldet sich lange nicht.",
        "Keine Zufahrt, da Baustelle!",
        "Ziehen bald um.",
        "Man bekommt einen Stromschlag, wenn man die Haustürklinke anfasst!!!",
        "Die Alarmanlage springt manchmal unversehens an...",
        "Gute Aussicht vom Dach!",
        "Hauskatze",
        "Haushund",
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now();
        foreach ($this->remarks as $remark) {
            $userId = rand(1, 4);
            DB::table('remarks')->insert([
                'remark_type_id' => rand(1, 3),
                'text' => $remark,
                'created_user_id' => $userId,
                'updated_user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        foreach ($this->addressRemarks as $remark) {
            $userId = rand(1, 4);
            DB::table('remarks')->insert([
                'remark_type_id' => rand(1, 3),
                'text' => $remark,
                'created_user_id' => $userId,
                'updated_user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        $contacts = \App\Model\Contact::all();
        $remarks = \App\Model\Remark::all();
        $i = 1;
        foreach ($contacts as $contact) {
            $contact->remarks()->attach($remarks[$i++]);
            if (rand(1, 2) == 1) {
                $contact->remarks()->attach($remarks[$i++]);
            }
            if (rand(1, 4) == 1) {
                $contact->remarks()->attach($remarks[$i++]);
            }
            if ($i > 20 ) $i = 1;
        }
        $addresses = \App\Model\Address::all();
        $i = 27;
        foreach ($addresses as $address) {
            $address->remarks()->attach($remarks[$i++]);
            if ($i > 37 ) $i = 21;
            if (rand(1, 2) == 1) {
                $address->remarks()->attach($remarks[$i++]);
                if ($i > 37 ) $i = 21;
            }
            if (rand(1, 4) == 1) {
                $address->remarks()->attach($remarks[$i++]);
                if ($i > 37 ) $i = 21;
            }
            if ($i > 37 ) $i = 21;
        }
    }
}
