<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schooling extends Model
{
    protected $table='schooling';
    
   /* protected $casts = [
        'start' => 'datetime:d/m/Y',
        'end' => 'datetime:d/m/Y',
    ];*/
    
    public function setStartAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['start'] = $carbon;
    }

    public function setEndAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['end'] = $carbon;
    }

}
