<?php

use App\Model\Account;
use App\Model\Address;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

class RefactorAddressIdToPivot extends Migration
{
    /**
     * ! Can't get rolled back as address_id is dropped
     *
     * @return void
     */
    public function up()
    {
        $out = new ConsoleOutput();
        if(Schema::hasColumn('accounts', 'address_id')) {
            $out->writeln("Refactoring accounts.address_id -> account_addresses with");
            $accounts = DB::table('accounts')->whereNotNull('address_id')->get();
            $accounts->each(function($acc) use ($out) {
                $addr = DB::table('addresses')->find($acc->address_id);
                DB::table('account_addresses')->insert(['account_id' => $acc->id, 'address_id' => $addr->id]);
            });
            Schema::table('accounts', function (Blueprint $table) {
                $table->dropColumn('address_id');
            });
        } else {
            $out->writeln('!addresses.address_id does not exist');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
