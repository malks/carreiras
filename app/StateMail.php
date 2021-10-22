<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StateMail extends Model
{
    protected $table='states_mails';

    public function states()
    {
        return $this->belongsToMany('App\State', 'states_mails_states', 'mail_id','state_id');
    }

}
