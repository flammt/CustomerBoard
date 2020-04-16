<?php

use App\Model\Address;
use App\Model\AddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput;

class AddTypeIdWithDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $out = new ConsoleOutput();
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedSmallInteger('type_id')->nullable();
        });
        $type = AddressType::where('name', 'Hauptadresse')->first();
        $out->writeln('Creating \'Hauptadresse\' type_id for all addresses');
        $ad = Address::all();
        $ad->each(function($a) use ($type) {
            $a->type_id = $type->id;
            $a->save();
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedSmallInteger('type_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
