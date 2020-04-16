<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $with = ['sector:id,name'];

    public function sector () {
        return $this->belongsTo('App\Model\Sector');
    }

    public function addresses () {
        return $this->belongsToMany('App\Model\Address', 'account_addresses', 'account_id', 'address_id')
            ->withTimestamps();
    }

    public function level () {
        return $this->belongsTo('App\Model\AccountLevel', 'account_level_id', 'id');
    }

    public function accountManager () {
        return $this->belongsTo('App\Model\User', 'account_manager_id', 'id');
    }

    public function closer () {
        return $this->belongsTo('App\Model\User', 'closer_id', 'id');
    }

    public function contacts () {
        return $this->hasMany('App\Model\Contact', 'account_id', 'id');
    }

    public function communications () {
        return $this->hasMany('App\Model\Communication', 'account_id', 'id');
    }



}
