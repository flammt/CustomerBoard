<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Contact extends Model
{
    use SoftDeletes;

    public function account () {
        return $this->belongsTo('App\Model\Account', 'account_id');
    }

    public function connections() {
        return $this->belongsToMany('App\Model\Connection', 'contact_connection', 'contact_id', 'connection_id');
    }

    public function remarks() {
        return $this->belongsToMany('App\Model\Remark', 'contact_remarks', 'contact_id', 'remark_id');
    }

    /**
    * Call deleting event on connections and the entries in the pivot table
    *
    * @return void
    */
    protected static function boot() {
        parent::boot();

        static::deleting(function($contact) {
            foreach($contact->connections()->withPivot('id')->get() as $connection) {
                $contact->connections()->updateExistingPivot($connection->pivot->connection_id, ['deleted_at' => \Carbon\Carbon::now()]);
                $connection->delete();
            }
        });
    }
}
