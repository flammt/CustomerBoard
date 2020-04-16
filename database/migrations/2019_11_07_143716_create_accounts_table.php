<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
            $table->text('mnemonic');
            $table->text('name');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('account_level_id');
            $table->unsignedBigInteger('account_manager_id')->nullable();
            $table->text('close_reason')->nullable();
            $table->unsignedBigInteger('closer_id')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->boolean('verbotskunde');
            $table->foreign('account_level_id')->references('id')->on('account_levels');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('closer_id')->references('id')->on('users');
            $table->foreign('account_manager_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function(Blueprint $table)
        {
            $table->dropForeign('accounts_account_level_id_foreign');
            $table->dropForeign('accounts_closer_id_foreign');
            $table->dropForeign('accounts_account_manager_id_foreign');
        });
        Schema::dropIfExists('accounts');
    }
}
