<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ProjectManager;

class ProjectController extends Controller {
    
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function all() {
        $projectManager = new ProjectManager();
        
        $paginator = $projectManager->getAllProject();
        
        return \View::make( 'project_list', [ 'paginator' => $paginator ] );
    }
    
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function asOwner() {
        $projectManager = new ProjectManager();
        
        $paginator = $projectManager->getProjectAsOwner();
        
        return \View::make( 'project_list', [ 'paginator' => $paginator ] );
    }
    
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function asMember() {
        $projectManager = new ProjectManager();
        
        $paginator = $projectManager->getProjectAsMember();
        
        return \View::make( 'project_list', [ 'paginator' => $paginator ] );
    }
    
    /**
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function createIndex(){
        
        return \View::make( 'project_create_index' );
        
    }
    
    /**
     * create a project
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(){
        $paramArr = \Request::all();
        
        $name = $paramArr['name'];
        $description = $paramArr['description'];
        $ownerId = $paramArr['owner'];
        $memberIdArr = $paramArr['member'];
        $deadline = $paramArr['deadline'];
        
        $projectManager = new ProjectManager();
        $projectManager->create( $name, $description, $ownerId, $memberIdArr, $deadline );
        
        
        return \Response::json( [ 'msg' => 'Create success.' ] );
        
    }
    
    /**
     * create a project
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(){
        $paramArr = \Request::all();
        
        $id = $paramArr['id'];
        $name = $paramArr['name'];
        $description = $paramArr['description'];
        $ownerId = $paramArr['owner'];
        $memberIdArr = $paramArr['member'];
        $deadline = $paramArr['deadline'];
        
        $projectManager = new ProjectManager();
        $projectManager->update( $id, $name, $description, $ownerId, $memberIdArr, $deadline );
        
        
        return \Response::json( [ 'msg' => 'Update success.' ] );
        
    }
    
    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\View
     */
    public function boardIndex( $projectId ){
        $projectManager = new ProjectManager();
        $boardInfoArr = $projectManager->findBoardInfo( $projectId );
    
        return \View::make( 'project_board', $boardInfoArr  );
    }
    
    /**
     * @param int $projectId
     * @return \Illuminate\Contracts\View\View
     */
    public function settingIndex( $projectId ){
        $projectManager = new ProjectManager();
        $projectArr = $projectManager->findWithAccessCheck( $projectId, \Auth::id() );
            
    
        return \View::make( 'project_setting_index', $projectArr  );
    }
    
    
}
