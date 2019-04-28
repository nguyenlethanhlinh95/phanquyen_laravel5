<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // model Role Quyen
    protected $fillable = ['name', 'display_name'];

    public function permissons()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
