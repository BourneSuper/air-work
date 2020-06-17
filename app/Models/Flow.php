<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author bourne
 * @property int project_id
 */
class Flow extends Model {
    
    public function project(){
        return $this->belongsTo( \App\Models\Project::class );
    }
    
    public function flowProcesses(){
        return $this->hasMany( \App\Models\FlowProcess::class );
    }
    
    
}
