<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Subscribed extends Pivot
{
    protected $table='subscribed';
    public $incrementing = true;


    public function states(){
        return $this->belongsToMany('App\State', 'subscribed_has_states', 'subscribed_id', 'state_id')->withTimestamps();
    }

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }

    public function job(){
        return $this->belongsTo('App\Job');
    }

}
