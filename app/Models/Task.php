<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Bourne
 * @property int project_id
 * @property int parent_id
 * @property int flow_process_id
 * @property int sort_num
 * @property string name
 * @property string description
 * @property int finished
 * @property int creator_id
 * @property string deadline
 *
 */
class Task extends Model{
    
    public function projects(){
        return $this->belongsTo( \App\Models\Project::class );
    }
    
    public function users(){
        return $this->belongsToMany( \App\User::class );
    }
    
    public function flowProcess(){
        return $this->belongsTo( \App\Models\FlowProcess::class );
    }
    
    public function parentTask(){
        return $this->belongsTo( \App\Models\Task::class, 'parent_id' );
    }
    
    public function subTask(){
        return $this->hasMany( \App\Models\Task::class );
    }
    
    
}
