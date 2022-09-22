<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Experience extends Model
{
    protected $table='experience';


    protected $casts = [
        'admission' => 'datetime:d/m/Y',
        'demission' => 'datetime:d/m/Y',
        'current_job' =>'boolean',
    ];

    public function setAdmissionAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['admission'] = $carbon;*/
        $this->attributes['admission'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setDemissionAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['demission'] = $carbon;*/
        $this->attributes['demission'] = implode("-",array_reverse(explode("/",$value)));
    }
}
