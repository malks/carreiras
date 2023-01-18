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

    public function defici()
    {
        return $this->belongsTo('App\Deficiency','deficiency_id');
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

    public function tagsrh(){
        return $this->belongsToMany('App\Tagrh', 'candidates_tagsrh', 'candidate_id', 'tag_id');
    }

    protected $casts = [
        'last_seen' => 'datetime:d/m/Y',
        'mother_dob' => 'date:d/m/Y',
        'father_dob' => 'date:d/m/Y',
        'lunelli_earlier_work_period_start' => 'date:d/m/Y',
        'lunelli_earlier_work_period_end' => 'date:d/m/Y',
        'last_time_doctor' => 'date:d/m/Y',
        'visa_expiration' => 'date:d/m/Y',
        'arrival_date' => 'date:d/m/Y',
        'dob' => 'date:d/m/Y',
    ];
    
    public function setLunelliEarlierWorkPeriodStartAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['lunelli_earlier_work_period_start'] = $carbon;*/
        $this->attributes['lunelli_earlier_work_period_start'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setLunelliEarlierWorkPeriodEndAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['lunelli_earlier_work_period_end'] = $carbon;*/
        $this->attributes['lunelli_earlier_work_period_end'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setLastTimeDoctorAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['last_time_doctor'] = $carbon;*/
        $this->attributes['last_time_doctor'] = implode("-",array_reverse(explode("/",$value)));
    }
    
    public function setVisaExpirationAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['visa_expiration'] = $carbon;*/
        $this->attributes['visa_expiration'] = implode("-",array_reverse(explode("/",$value)));
    }
    
    public function setArrivalDateAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['arrival_date'] = $carbon;*/
        $this->attributes['arrival_date'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setDobAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['dob'] = $carbon;*/
        $this->attributes['dob'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setLastSeenAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['last_seen'] = $carbon;*/
        $this->attributes['last_seen'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setMotherDobAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['mother_dob'] = $carbon;*/
        $this->attributes['mother_dob'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setFatherDobAttribute($value)
    {
        /*$carbon = new Carbon($value);
        $carbon->toDateTimeString();
        $this->attributes['father_dob'] = $carbon;*/
        $this->attributes['father_dob'] = implode("-",array_reverse(explode("/",$value)));
    }

    public function setMobileAttribute($value)
    {
        $this->attributes['mobile'] = str_replace(["-","."],"",$value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(["-","."],"",$value);
    }

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = str_replace(["-","."],"",$value);
    }

    public function setPisAttribute($value)
    {
        $this->attributes['pis'] = str_replace(["-","."],"",$value);
    }

    public function setRgAttribute($value)
    {
        $this->attributes['rg'] = str_replace(["-","."],"",$value);
    }

    public function setWorkCardAttribute($value)
    {
        $this->attributes['work_card'] = str_replace(["-","."],"",$value);
    }

    public function setWorkCardSeriesAttribute($value)
    {
        $this->attributes['work_card_series'] = str_replace(["-","."],"",$value);
    }

    public function setElectorCardAttribute($value)
    {
        $this->attributes['elector_card'] = str_replace(["-","."],"",$value);
    }

    public function setVeteranCardAttribute($value)
    {
        $this->attributes['veteran_card'] = str_replace(["-","."],"",$value);
    }

    public function setCidAttribute($value)
    {
        $this->attributes['cid'] = str_replace(["-","."],"",$value);
    }

    public function setZipAttribute($value)
    {
        $this->attributes['zip'] = str_replace(["-","."],"",$value);
    }

}
