<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CommunicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sprueche = [
          "Das Reh springt hoch, das Reh springt weit, warum auch nicht, es hat ja Zeit!",
          "Der Glatzkopf der die Glatze föhnt, hat mit dem Schicksal sich versöhnt.",
          "Der See lädt ein zum Bade...ausgetrocknet...Schade.",
          "Verweile nicht in der Vergangenheit, träume nicht von der Zukunft. Konzentriere dich auf den gegenwärtigen Moment.",
          "Wir denken selten an das, was wir haben, aber immer an das, was uns fehlt.",
          "Du siehst die Welt nicht so wie sie ist, du siehst die Welt so wie du bist.",
          "Alle Menschen, die man lange im Vorzimmer seiner Gunst stehen läßt, geraten in Gärung oder werden sauer.",
          "Der Philosoph glaubt, der Wert seiner Philosophie liege im Ganzen, im Bau: die Nachwelt findet ihn im Stein, mit dem er baute und mit dem, von da an, noch oft und besser gebaut wird: also darin, daß jener Bau zerstört werden kann und doch noch als Material Wert hat.",
          "Wo ich Lebendiges fand, da fand ich Willen zur Macht; und noch im Willen des Dienenden fand ich den Willen, Herr zu sein.",
          "Was du mir sagst, das vergesse ich. Was du mir zeigst, daran erinnere ich mich. Was du mich tun lässt, das verstehe ich.",
            "Wo ist das verdammte Geld, Lebowski ? Wo ist das verdammte Geld, du Drecksack?",
            "Ohne Handeln sind die besten Absichten in der Welt nichts weiter als das: Absichten.",
            "Die einzige Sache, die zwischen dir und deinem Ziel steht, sind die Bullshit Ausreden, die du dir ständig selbst erzählst.",
            "Die Tatsache, dass auf Euren Waffen klar und deutlich 'Replica' steht, und auf meiner 'Desert Eagle 0,50' sollte euch zu denken geben.",
            "Gerne der Zeiten gedenk' ich, da alle Glieder gelenkig - bis auf eins. Doch die Zeiten sind vorüber, steif geworden alle Glieder - bis auf eins.",
            "Weisheit stellt sich nicht immer mit dem Alter ein. Manchmal kommt auch das Alter ganz allein.",
            "Geliebt wirst du einzig, wo du schwach dich zeigen darfst, ohne Stärke zu provozieren.",
            "Stärke wächst nicht aus körperlicher Kraft - vielmehr aus unbeugsamen Willen.",
            "Man will nicht nur glücklich sein, sondern glücklicher als die anderen. Und das ist deshalb so schwer, weil wir die anderen für glücklicher halten, als sie sind.",
            "Mut ist, wenn man Todesangst hat, aber sich trotzdem in den Sattel schwingt.",
            "Die Frau kontrolliert ihren Sex, weil sie für Sex all das bekommt, was ihr noch wichtiger ist als Sex.",
            "Wer lachen kann, dort wo er hätte heulen können, bekommt wieder Lust zum Leben.",

            "Eigentlich wollte ich dir schenken eine Torte. Doch ich kann leider nicht backen. Darum gibt es nur nette Worte.",
            "Vertrauen ist wie Papier. Wenn man es einmal zerknüllt, wird es nie wieder perfekt.",
            "Folge deinem Herzen, aber nimm dein Hirn mit.",
            "Sobald du anfängst, dir Gedanken darüber zu machen, was Andere über dich denken, hörst du auf, du selbst zu sein.",
            '"Wie trinkst du deinen Kaffee?" "Müde."',
            "Bist du traurig, hast du Sorgen, soll ich dir mein Lächeln borgen? Nutz es gut, es bringt dir Glück und wenn du`s nicht mehr brauchst, gib`s mir irgendwann zurück.",
            "Wer will findet Wege, wer nicht will, der findet Gründe.",
            "Alle sagten: Das geht nicht. Dann kam einer, der wusste das nicht und hat's gemacht.",
        ];

        $now = \Carbon\Carbon::now();
        for ($i = 1; $i < 101; $i++) {
            DB::table('communications')->insert([
                    [
                        'date' => \Carbon\Carbon::now()->subDays(rand(1, 31)),
                        'account_id' => $i,
                        'contact_id' => rand(1, 3),
                        'user_id' => rand(1, 4),
                        'communication_type_id' => rand(1, 4),
                        'memo' => $sprueche[rand(0, 16)],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ],
                ]
            );
            $max = rand(2, 12);
            for($j = 1; $j<$max; $j++) {
                DB::table('communications')->insert([
                        [
                            'date' => \Carbon\Carbon::now()->subDays(rand(1, 31)),
                            'account_id' => $i,
                            'contact_id' => rand(1, 300),
                            'user_id' => rand(1, 4),
                            'communication_type_id' => rand(1, 4),
                            'memo' => $sprueche[rand(0, 29)],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    ]
                );
            }
        }
    }
}
