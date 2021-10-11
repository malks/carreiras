<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'role_has_permissions', 'role_id', 'permission_id');
    }
}
