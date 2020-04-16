<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connection extends Model
{
    use SoftDeletes;

    protected $with = ['type:id,name'];

    public function type () {
        return $this->belongsTo('App\Model\Connectiontype', 'connectiontype_id');
    }
}
