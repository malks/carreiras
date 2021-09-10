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

    public function langs()
    {
        return $this->belongsToMany('App\Language', 'candidate_languages', 'candidate_id', 'language_id')->withPivot('level');
    }

    public function subscriptions(){
        return $this->belongsToMany('App\Job', 'subscribed', 'candidate_id', 'job_id');
    }

    public function interests(){
        return $this->belongsToMany('App\Tag', 'candidates_tags', 'candidate_id', 'tag_id');
    }

    /*protected $casts = [
        'last_seen' => 'datetime:d/m/Y',
        'mother_dob' => 'date:d/m/Y',
        'father_dob' => 'date:d/m/Y',
    ];*/
    
    public function setLunelliEarlierWorkPeriodStartAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['lunelli_earlier_work_period_start'] = $carbon;
    }

    public function setLunelliEarlierWorkPeriodEndAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['lunelli_earlier_work_period_end'] = $carbon;
    }

    public function setLastTimeDoctorAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['last_time_doctor'] = $carbon;
    }
    
    public function setVisaExpirationAttribute($value)
    {
        $carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['visa_expiration'] = $carbon;
    }
    
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
