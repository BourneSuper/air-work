<?php
namespace App\Service;

use App\Models\Project;
use App\User;
class ProjectManager {
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProject(){
        
        $userId = \Auth::id();
        
        $allProjectArr = \DB::table( 'projects' )
                ->whereIn( 'projects.id', 
                            \DB::table( 'user_project' )
                                    ->where( 'user_project.user_id', '=', $userId )
                                    ->select( 'user_project.project_id' )
                )
                ->orWhere( 'projects.owner_id', '=', $userId )
                ->orderBy( 'projects.created_at', 'desc' )
                ->select( 'projects.id', 'projects.owner_id', 'projects.owner_name', 'projects.name', 'projects.description', 'projects.deadline', 'projects.created_at' )
                ->paginate(10);
        
        return $allProjectArr; 
    }
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProjectAsOwner(){
        
        $userId = \Auth::id();
        
        $allProjectArr = \DB::table( 'projects' )
                ->where( "projects.owner_id", "=", $userId )
                ->orderBy( 'projects.created_at', 'desc' )
                ->select( 'projects.id', 'projects.owner_id', 'projects.owner_name', 'projects.name', 'projects.description', 'projects.deadline', 'projects.created_at' )
                ->paginate(10);
        
        return $allProjectArr; 
    }
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProjectAsMember(){
        
        $userId = \Auth::id();
        
        $allProjectArr = \DB::table( 'projects' )
                ->join( 'user_project', 'projects.id', '=', 'user_project.user_id' )
                ->where( "user_project.user_id", "=", $userId )
                ->groupBy( 'projects.id' )
                ->orderBy( 'projects.created_at', 'desc' )
                ->select( 'projects.id', 'projects.owner_id', 'projects.owner_name', 'projects.name', 'projects.description', 'projects.deadline', 'projects.created_at' )
                ->paginate(10);
        
        return $allProjectArr; 
    }
    
    /**
     * @param string $name
     * @param string $description
     * @param int $ownerId
     * @param array $memberIdArr
     * @param unknown $deadline
     */
    public function create( $name, $description, $ownerId, $memberIdArr, $deadline ){
        \DB::transaction( function() use( $name, $description, $ownerId, $memberIdArr, $deadline ){ 
            $project = new Project();
            $project->name = $name;
            $project->description = $description;
            $project->deadline = $deadline;
            $project->owner_id = $ownerId;
            $project->owner_name = User::find( [ $ownerId ] )->first()->name;
            
            $project->save();
            
            //
            /**
             * @var \App\Models\Flow $flow
             */
            $flowManager = new FlowManager();
            $flow = $flowManager->createDevelopeFLow( $project->id );
            
            
            //
            $memberCollection = User::find( $memberIdArr );
            $project->members()->saveMany( $memberCollection );
            
        });
        
        
        return true;
        
    }
    
    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param int $ownerId
     * @param array $memberIdArr
     * @param string $deadline
     * @throws MsgException
     * @return boolean
     */
    public function update( $id, $name, $description, $ownerId, $memberIdArr, $deadline ){
        /**
         * @var \App\Models\Project $project
         */
        $project = Project::find( [ $id ] )->first();
        
        if( !$project ){
            throw new MsgException( 'Project not exists.' );
        }
        
        $project->name = $name;
        $project->description = $description;
        $project->deadline = $deadline;
        $project->owner_id = $ownerId;
        $project->owner_name = User::find( [ $ownerId ] )->first()->name;
        
        $project->save();
        
        //
        $memberCollection = User::find( $memberIdArr );
        $project->members()->detach();
        $project->members()->saveMany( $memberCollection );
        
        
        return true;
        
    }
    
    /**
     * @param int $id
     */
    public function findBoardInfo( $id ){
        /**
         * @var \App\Models\Project  $project
         */
         $project = Project::find( [ $id ] )->first();
         
         return [ 'project' => $project, 'flow' => $project->flow()->get()->first() ];
        
     }
    
    /**
     * @param int $id
     */
    public function findWithAccessCheck( $id, $userId ){

         $projectOwnerManager = new ProjectOwnerManager();
         
         /**
          * @var \App\Models\ProjectOwner $projectOwner
          */
         $projectOwner = $projectOwnerManager->isProjectOwner( $id, $userId ); 
         
         if( !$projectOwner ){
             throw new MsgException( 'Access deny.' );
         }
         
         $project = $projectOwner->getProject();
         
         $memberIdCSVStr = implode( ',', array_column( $project->members()->get( [ 'users.id' ]  )->toArray(), 'id' ) );
         
         return [ 'project' => $project, 'memberIdCSVStr' => $memberIdCSVStr ];
        
     }
     
     
    
    
    
    
    
}

?>