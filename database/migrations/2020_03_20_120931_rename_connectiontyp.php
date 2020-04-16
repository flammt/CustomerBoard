<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameConnectiontyp extends Migration
{

    private $old = 'connectiontyps';
    private $new = 'connectiontypes';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connections', function(Blueprint $table) {
            $table->dropForeign('connections_connectiontype_id_foreign');
        });
        Schema::rename($this->old, $this->new);
        Schema::table('connections', function(Blueprint $table) {
                $table->foreign('connectiontype_id')->references('id')->on('connectiontypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connections', function(Blueprint $table) {
            $table->dropForeign('connections_connectiontype_id_foreign');
        });
        Schema::rename($this->new, $this->old);
        Schema::table('connections', function(Blueprint $table) {
                $table->foreign('connectiontype_id')->references('id')->on('connectiontyps');
        });
    }
}
