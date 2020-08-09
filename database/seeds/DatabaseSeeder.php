<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->command->info('Users table seeded');

        $this->call(GermanCompaniesSeeder::class);
        $this->command->info('German companies seeded');

        $this->call(ContactsSeeder::class);
        $this->command->info('Contacts seeded');

        $this->call(CommunicationTypesSeeder::class);
        $this->command->info('Communication Types seeded');

        $this->call(CommunicationsSeeder::class);
        $this->command->info('Communications seeded');
    }


}
