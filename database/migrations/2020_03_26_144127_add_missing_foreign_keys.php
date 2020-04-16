<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('remarks', function (Blueprint $table) {
            $table->foreign('remark_type_id')->references('id')->on('remark_types');
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('sector_id')->references('id')->on('sectors');
        });
        Schema::table('account_addresses', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('address_id')->references('id')->on('addresses');
        });
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('address_types');
        });
        Schema::table('communications', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('communication_type_id')->references('id')->on('communication_types');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function(Blueprint $table) {
            $table->dropForeign('contacts_account_id_foreign');
        });
        Schema::table('communications', function(Blueprint $table) {
            $table->dropForeign('communications_account_id_foreign');
            $table->dropForeign('communications_communication_type_id_foreign');
            $table->dropForeign('communications_contact_id_foreign');
            $table->dropForeign('communications_user_id_foreign');
        });
        Schema::table('addresses', function(Blueprint $table) {
            $table->dropForeign('addresses_type_id_foreign');
        });
        Schema::table('account_addresses', function(Blueprint $table) {
            $table->dropForeign('account_addresses_account_id_foreign');
            $table->dropForeign('account_addresses_address_id_foreign');
        });
        Schema::table('accounts', function(Blueprint $table) {
            $table->dropForeign('accounts_sector_id_foreign');
        });
        Schema::table('remarks', function(Blueprint $table) {
            $table->dropForeign('remarks_remark_type_id_foreign');
        });
    }
}
