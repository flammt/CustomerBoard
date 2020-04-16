<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remark extends Model
{
    use SoftDeletes;

    protected $with = ['type:id,name'];

    public function type () {
        return $this->belongsTo('App\Model\RemarkType', 'remark_type_id');
    }
}
