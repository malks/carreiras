<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Experience extends Model
{
    protected $table='experience';

/*
    protected $casts = [
        'admission' => 'datetime:d/m/Y',
        'demission' => 'datetime:d/m/Y',
    ];
*/

    public function setAdmissionAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['admission'] = $carbon;
    }

    public function setDemissionAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['demission'] = $carbon;
    }
}
