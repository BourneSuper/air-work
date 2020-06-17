<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $description
 * @property int $owner_id
 * @property string $owner_name
 * @property string $deadline
 * @property int flow_id
 * @author bourne
 *
 */
class Project extends Model {
    
    
    public function tasks(){
        return $this->hasMany( \App\Models\Task::class );
    }
    
    public function owner(){
        return $this->belongsTo( \App\User::class, 'owner_id' );
    }
    
    public function canModiedRoles(){
        return $this->belongsToMany( \App\Models\Role::class, 'role_project' );
    }
    
    public function members(){
        return $this->belongsToMany( \App\User::class, 'user_project' );
    }
    
    public function flow(){
        return $this->hasOne( \App\Models\Flow::class );
    }
    
}
