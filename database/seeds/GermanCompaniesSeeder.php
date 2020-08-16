<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GermanCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lines = explode("\n", file_get_contents('database/seeds/german_companies.txt'));
        $companies = [];
        foreach ($lines as $line) {
            if (empty($line)) {}
            elseif ($this->startsWith($line, '#')) {}
            elseif ($line === 'Mitarbeiter') {}
            elseif (is_numeric(trim(preg_replace('/\s\s+/', ' ', $line)))) {}
            elseif ($this->startsWith($line, 'Logo') || $line === 'kein Logo') {}
            else {
                $companies[] = $line;
            }
        }

        $now = \Carbon\Carbon::now();
        DB::table('account_levels')->insert([
            [
                'level' => '1',
                'description' => 'Interessiert',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'level' => '2',
                'description' => 'Teilweise Bindung',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'level' => '3',
                'description' => 'Hauptkunde',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
        $i = 0;
        while ($i < sizeof($companies) -1) {
            $name = $companies[$i++];
            $street = $companies[$i++];
            $url = $companies[$i++];
            $plz = substr($companies[$i], 0, 5);
            $town = substr($companies[$i], 6, strlen($companies[$i++])-5);
            $account = new \App\Model\Account();
            $account->name = $name;
            $account->sector_id = rand(1, 5);
            $account->verbotskunde = false;
            $account->account_manager_id = rand(1, 4);
            $account->account_level_id = rand(1, 3);
            $account->mnemonic = substr($name, 0, 3);
            $future = $now->copy()->addDays(rand(1, 90))->setTime(rand(8, 16), [0, 30][rand(0, 1)]);
            $account->next_contact = $future;
            $account->save();
            // Hauptadresse
            $address = new \App\Model\Address();
            $address->name1 = $name;
            $address->street = $street;
            $address->zip = $plz;
            $address->town = $town;
            $address->country_code = 'D';
            $address->type_id = 1;
            $address->save();
            $account->addresses()->attach($address);
            // Weitere
            $address = new \App\Model\Address();
            $address->name1 = $name;
            $address->street = $street;
            $address->zip = $plz;
            $address->town = $town;
            $address->country_code = 'D';
            $address->type_id = rand(2, 3);
            $address->save();
            $account->addresses()->attach($address);
        }
    }

    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}
