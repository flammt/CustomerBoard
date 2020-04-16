<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    public function account () {
        return $this->belongsTo('App\Model\Account');
    }

    public function contact () {
        return $this->belongsTo('App\Model\Contact');
    }

    public function user () {
        return $this->belongsTo('App\Model\User');
    }

    public function type () {
        return $this->belongsTo('App\Model\CommunicationType', 'communication_type_id', 'id');
    }
}
