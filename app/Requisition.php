<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    public function field()
    {
        return $this->belongsTo('App\Field');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

}
