<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Candidate extends Model
{
    public function schooling()
    {
        return $this->hasMany('App\Schooling');
    }

    public function experience()
    {
        return $this->hasMany('App\Experience');
    }

    public function subscriptions(){
        return $this->belongsToMany('App\Job', 'subscribed', 'candidate_id', 'job_id');
    }

    protected $casts = [
        'arrival_date' => 'date:d/m/Y',
        'dob' => 'date:d/m/Y',
        'last_seen' => 'datetime:d/m/Y',
        'mother_dob' => 'date:d/m/Y',
        'father_dob' => 'date:d/m/Y',
    ];
    
    public function setArrivalDateAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['arrival_date'] = $carbon;
    }

    public function setDobAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['dob'] = $carbon;
    }

    public function setLastSeenAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['last_seen'] = $carbon;
    }

    public function setMotherDobAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['mother_dob'] = $carbon;
    }

    public function setFatherDobAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['father_dob'] = $carbon;
    }

}
