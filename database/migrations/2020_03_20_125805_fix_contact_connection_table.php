<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixContactConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_connection', function(Blueprint $table) {
            $table->dropForeign('contact_connection_address_id_foreign');
            $table->dropForeign('contact_connection_contact_id_foreign');

            $table->dropColumn('address_id');
            $table->dropColumn('contact_id');
        });

        Schema::table('contact_connection', function(Blueprint $table) {
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('connection_id');

            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('connection_id')->references('id')->on('connections');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_connection', function(Blueprint $table) {
            $table->dropForeign('contact_connection_connection_id_foreign');
            $table->dropForeign('contact_connection_contact_id_foreign');

            $table->dropColumn('contact_id');
            $table->dropColumn('connection_id');
        });

        Schema::table('contact_connection', function(Blueprint $table) {
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('contact_id');

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('contact_id')->references('id')->on('contacts');

        });
    }
}
