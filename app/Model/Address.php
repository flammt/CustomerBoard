<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $with = ['type:id,name'];

    public function type () {
        return $this->belongsTo('App\Model\AddressType');
    }

    public function connections() {
        return $this->belongsToMany('App\Model\Connection', 'address_connection', 'address_id', 'connection_id');
    }

    public function remarks() {
        return $this->belongsToMany('App\Model\Remark', 'address_remarks', 'address_id', 'remark_id');
    }
}
