<?php

namespace App\Models;

use App\User;

class ProjectOwner extends User{
    /**
     * @var \App\Models\Project $project
     */
    protected $project ;
    /**
     * @var \App\User $user
     */
    protected $user ;
    
    /**
     * @param \App\Models\Project $project
     * @param \App\User $user
     */
    public function __construct( $project, $user ){
        $this->project = $project;
        $this->user = $user;
    }
    
    /**
     * @return the $project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \App\Models\Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @param \App\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    
    
    
}
