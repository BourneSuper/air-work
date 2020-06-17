<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Bourne
 * @property int $project_id
 * @property int $flow_id
 * @property int $sort_num
 * @property string $name
 * @property string $description
 */
class FlowProcess extends Model {
    
    public function flow(){
        return $this->belongsTo( \App\Models\Flow::class );
    }
    
    public function tasks(){
        return $this->hasMany( \App\Models\Task::class );
    }
    
}
