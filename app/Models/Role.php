<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{
    
    public function users(){
        return $this->belongsToMany( \App\User::class );
    }
    
    public function inProjects(){
        return $this->belongsToMany( \App\Models\Project::class );
    }
    
    
    
}
