<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommunicationsAddIndicesAccountIdCreatedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->index('account_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communications', function (Blueprint $table) {
            $table->dropIndex('communications_account_id_index');
            $table->dropIndex('communications_created_at_index');
        });
    }
}
