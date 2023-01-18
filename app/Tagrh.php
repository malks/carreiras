<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagrh extends Model
{
    protected $table='tags_rh';

    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }

}
