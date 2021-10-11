<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTemplate extends Model
{
    protected $table='jobs_templates';


    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'jobs_templates_tags', 'job_id', 'tag_id');
    }
    
    public function field()
    {
        return $this->belongsTo('App\Field');
    }

}
