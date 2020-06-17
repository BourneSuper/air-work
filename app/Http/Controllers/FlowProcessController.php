<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlowProcess;
use App\Service\FlowProcessManager;

class FlowProcessController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request ) {
        $validatedData = $request->validate([
            'flowId' => 'required|integer|min:0',
            'prevFlowProcessId' => 'nullable|string',
            'sortNum' => 'nullable|integer|min:0',
        ]);
    
        $flowProcessManager = new FlowProcessManager();
    
        $flowProcess = $flowProcessManager->create(
                $validatedData['flowId'], $validatedData['prevFlowProcessId'], $validatedData['sortNum']
        );
    
    
        return \Response::json( [ 'msg' => 'update success.', 'id' => $flowProcess->id ] );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request ) {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:0',
            'name' => 'required|string',
            'sortNum' => 'nullable|integer|min:0',
        ]);
        
        
        $flowProcessManager = new FlowProcessManager();
        
        $flowProcessManager->update( $validatedData['id'], $validatedData['name'], $validatedData['sortNum'] );
        
        
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
        
        $flowProcessManager = new FlowProcessManager();
        
        $flowProcessManager->delete( $validatedData['id'] );
        
        
        return \Response::json( [ 'msg' => 'delete success.' ] );
    }
    

}
