<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Service\TaskManager;

class TaskController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request ) {
        $validatedData = $request->validate([
            'flowProcessId' => 'required|integer|min:0',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'sortNum' => 'nullable|integer|min:0',
        ]);
        
        
        $taskManager = new TaskManager();
        
        $task = $taskManager->create( 
            $validatedData['flowProcessId'], $validatedData['name'],
            $validatedData['description'], $validatedData['deadline'], $validatedData['sortNum'] 
        );
        
        
        return \Response::json( [ 
                'msg' => 'create success.', 
                'id' => $task->id, 
                'sortNum' => $task->sort_num  
        ] );
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request ) {
        $validatedData = $request->validate([
            'flowProcessId' => 'required|integer|min:0',
            'id' => 'required|integer|min:0',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'sortNum' => 'nullable|integer|min:0',
            'finished' => 'nullable|integer|min:0|max:1',
        ]);
        
        
        $taskManager = new TaskManager();
        
        $taskManager->update( 
            $validatedData['flowProcessId'], $validatedData['id'], $validatedData['name'],
            $validatedData['description'], $validatedData['deadline'], $validatedData['sortNum'],
            $validatedData['finished']
        );
        
        
        return \Response::json( [ 'msg' => 'update success.' ] );
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete( Request $request ){
        $validatedData = $request->validate([
            'id' => 'required|integer|min:0',
        ]);
    
        $taskManager = new TaskManager();
    
        $taskManager->delete( $validatedData['id'] );
    
    
        return \Response::json( [ 'msg' => 'delete success.' ] );
    }

}
