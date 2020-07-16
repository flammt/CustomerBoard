<?php
//
//use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
//
//class DatabaseSeeder extends Seeder
//{
//    /**
//     * Seed the application's database.
//     *
//     * @return void
//     */
//    public function run()
//    {
//        $this->call(UsersTableSeeder::class);
//        $this->command->info('Users table seeded');
//
//        $path = 'database/seeds/sql/users_1000.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Users 1000 table seeded');
//
//        $path = 'database/seeds/sql/address_types.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Address_types table seeded');
//
//        $path = 'database/seeds/sql/addresses.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Addresses table seeded');
//
//        $path = 'database/seeds/sql/account_levels.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Account_levels table seeded');
//
//        $path = 'database/seeds/sql/contacts.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Contacts table seeded');
//
//        $path = 'database/seeds/sql/accounts.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Accounts table seeded');
//
//        $path = 'database/seeds/sql/account_addresses.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Account_addresses table seeded');
//
//        $path = 'database/seeds/sql/communication_types.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Communication_types table seeded');
//
//        $path = 'database/seeds/sql/communications.sql';
//        DB::unprepared(file_get_contents($path));
//        $this->command->info('Communications table seeded');
//
////        DB::raw("SELECT setval('users_id_seq', COALESCE((SELECT MAX(id)+1 FROM users), 1), false);");
////        DB::raw("SELECT setval('accounts_id_seq', COALESCE((SELECT MAX(id)+1 FROM accounts), 1), false);");
////        DB::raw("SELECT setval('account_levels_id_seq', COALESCE((SELECT MAX(id)+1 FROM account_levels), 1), false);");
////        DB::raw("SELECT setval('account_managers_id_seq', COALESCE((SELECT MAX(id)+1 FROM account_managers), 1), false);");
////        DB::raw("SELECT setval('addresses_id_seq', COALESCE((SELECT MAX(id)+1 FROM addresses), 1), false);");
////        DB::raw("SELECT setval('communications_id_seq', COALESCE((SELECT MAX(id)+1 FROM communications), 1), false);");
////        DB::raw("ALTER SEQUENCE users_id_seq RESTART WITH 1001");
////        DB::raw("ALTER SEQUENCE addresses_id_seq RESTART WITH 1001");
////        DB::raw("ALTER SEQUENCE account_levels_id_seq RESTART WITH 10");
////        DB::raw("ALTER SEQUENCE contacts_id_seq RESTART WITH 1001");
////        DB::raw("ALTER SEQUENCE accounts_id_seq RESTART WITH 1001");
////        DB::raw("ALTER SEQUENCE communication_types_id_seq RESTART WITH 10");
////        DB::raw("ALTER SEQUENCE communications_id_seq RESTART WITH 1001");
//    }
//}
