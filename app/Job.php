<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function field()
    {
        return $this->belongsTo('App\Field');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'jobs_tags', 'job_id', 'tag_id');
    }

}