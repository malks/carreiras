<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
