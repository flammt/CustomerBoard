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
          "(303775) 2005 QU182 ist ein großes transneptunisches Objekt, das bahndynamisch als Scattered Disk Object (SDO) eingestuft wird. Aufgrund seiner Größe ist der Asteroid ein Zwergplanetenkandidat.",
          "Der Designer Michel Joubert wollte ursprünglich ein gemütliches Segelboot für den Familienausflug entwerfen. Zu seiner großen Überraschung (Surprise), war das Boot jedoch viel sportlicher als geplant. Die Surprise wurde zu einer international beliebten Regattaklasse. Sie ist heute vor allem in Frankreich, Österreich, der Schweiz und Süddeutschland verbreitet. Sie hat vier Kojen. Die Stehhöhe in der Kajüte beträgt 1,45 m.",
          "Als Konzertpianist trat Lévy in ganz Europa, Afrika und Asien auf. Er führte als erster französischer Pianist die Werke Skrjabins auf und war einer der ersten Pianisten, der sich im 20. Jahrhundert ernsthaft mit dem Klavierwerk Schuberts auseinandersetzte. Er trat unter Dirigenten wie Désiré-Émile Inghelbrecht, Dimitri Mitropoulos, Pierre Monteux, Charles Munch, Paul Paray und Felix Weingartner auf und war befreundet mit Edwin Fischer, André Marchal, Sergei Rachmaninoff, dem Philosophen Emmanuel Levinas und mit André Malraux.",
          "Das Spiel endet direkt nach der dritten Wertungsrunde mit einer Endwertung, bei der noch die Monsterkarten gewertet werden, die ein Symbol für die Endwertung aufweisen. Diese geben jeweils eine feste Anzahl Siegpunkte für bestimmte Gebäude oder Biome. Der Spieler, der am Ende der Schlusswertung die meisten Punkte hat, gewinnt das Spiel. Bei Gleichstand gewinnt der Spieler, der noch die meisten Blöcke im eigenen Vorrat übrig hat, und gibt es dann noch immer einen Gleichstand, gewinnen alle daran Beteiligten.",
          "Kartiert wurde der Nunatak bei der Fünften Französischen Antarktisexpedition (1908–1910) unter der Leitung des Polarforschers Jean-Baptiste Charcot. Der weitere Benennungshintergrund ist unbekannt. Möglicher Namensgeber ist ein Sponsor der Forschungsreise.",
          "Die Figur des Richard Ginelli taucht erstmals in dem Roman Der Fluch auf, in dem er auch eine tragende Rolle spielt.",
          "Das Dorf liegt am nordöstlichen Rand des Großen Kaukasus knapp 10 km Luftlinie südsüdöstlich des Zentrums Republikhauptstadt Machatschkala und etwa 4 km von der Küste des Kaspischen Meeres entfernt. Es ist der Verwaltung des Leninski rajon, eines der drei Stadtbezirke von Machatschkala, unterstellt.",
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
        }
    }
}
