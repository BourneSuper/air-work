<?php
namespace App\Service;

use App\Models\Project;
use App\Models\ProjectOwner;

class ProjectOwnerManager {
    
    /**
     * @param int $projectId
     * @param int $userId
     * @return \App\Models\ProjectOwner | boolean
     */
    public function isProjectOwner( $projectId, $userId ){
        /**
         * @var \App\Models\Project  $project
         */
        $project = Project::where( [ 'id' => $projectId, 'owner_id' => $userId ] )->get()->first();
    
        if( !$project ){
            return false;
        }
        
        $user = $project->owner()->get()->first();
    
        if( $user ){
            return new ProjectOwner( $project, $user );
        }
    
        return false;
    }
    
}

?>