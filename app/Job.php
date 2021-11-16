<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function field()
    {
        return $this->belongsTo('App\Field');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'jobs_tags', 'job_id', 'tag_id');
    }

    public function subscribers(){
        return $this->belongsToMany('App\Candidate', 'subscribed', 'job_id','candidate_id')->withTimestamps()->withPivot('notes');
    }

    public function subscriptions(){
        return $this->hasMany('App\Subscribed');
    }

    public function requisitions(){
        return $this->hasMany('App\Requisition','cod_senior','cod_senior');
    }

}