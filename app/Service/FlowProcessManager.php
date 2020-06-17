<?php
namespace App\Service;

use App\Models\FlowProcess;
use App\Models\Project;
use App\Models\Flow;
use App\Models\Task;
class FlowProcessManager {

    
    /**
     * @param \Illuminate\Database\Eloquent\Collection $flowProcessCollection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sort( $flowProcessCollection ){
        return $flowProcessCollection->sortBy( function ( $value, $key ){
            return $value->sort_num;
        } );
        
    }
    
    /**
     * @param int $id
     * @param string $name
     * @param string $sortName
     * @throws MsgException
     */
    public function update( $id, $name, $sortNum = null ){
        /**
         * @var \App\Models\FlowProcess $flowProcess
         */
        $flowProcess = FlowProcess::find( [ $id ] )->first();
        
        if( empty($flowProcess) ){
            throw new MsgException( 'FlowProcess not exists.' );
        }
        
        \DB::transaction( function() use( $flowProcess, $id, $name, $sortNum ){
            $oldSortNum = $flowProcess->sort_num;
            
            $flowProcess->name = $name;
            $sortNum === null ? '' : $flowProcess->sort_num = $sortNum ;
            
            if( !empty( $sortNum ) ){
                if( $oldSortNum < $sortNum ){
                        \DB::table('flow_processes')
                                ->where( 'flow_id', $flowProcess->flow_id )
                                ->where( 'sort_num', '>', $oldSortNum )
                                ->where( 'sort_num', '<=', $sortNum )
                                ->where( 'id', '!=', $flowProcess->id )
                                ->decrement( 'sort_num' );
                }
                
                if( $oldSortNum > $sortNum  ){
                        \DB::table('flow_processes')
                                ->where( 'flow_id', $flowProcess->flow_id )
                                ->where( 'sort_num', '>=', $sortNum )
                                ->where( 'sort_num', '<', $oldSortNum )
                                ->where( 'id', '!=', $flowProcess->id )
                                ->increment( 'sort_num' );
                }
            }
            
            $flowProcess->save();
            
            return true;
        } );
        
        return false;
        
    }
    
    
    /**
     * @param int $flowId
     * @param int $prevFlowProcessId
     * @param int $sortNum
     * @throws MsgException
     * @return unknown
     */
    public function create( $flowId, $prevFlowProcessId, $sortNum ) {
        
        /**
         * @var \App\Models\Flow $flow
         */
        $flow = Flow::find( [$flowId] )->first();
        if( empty($flow) ){
            throw new MsgException( 'Flow not exists.' );
        }
        
        /**
         * @var \App\Models\FlowProcess $prevflowProcess
         */
        $prevflowProcess = FlowProcess::find( [ $prevFlowProcessId ] )->first();
        
        if( empty($prevflowProcess) ){
            throw new MsgException( 'FlowProcess not exists.' );
        }
        
        
        $flowProcess = new FlowProcess();
        
        $flowProcess->project_id = $flow->project_id;
        $flowProcess->flow_id = $flow->id;
//         $flowProcess->prev_flow_process_id = $prevflowProcess->id;
        $flowProcess->sort_num = $sortNum;
        
        $flowProcess->save();
        
        //
//         $prevflowProcess->next_flow_process_id = $flowProcess->id;
        $prevflowProcess->save();
        
        return $flowProcess;
        
    }
    
    /**
     * @param int $id
     * @throws MsgException
     * @return boolean
     */
    public function delete( $id ){
        \DB::transaction(function () use( $id ) {
            /**
             * @var \App\Models\FlowProcess $flowProcess
             */
            $flowProcess = FlowProcess::find( [ $id ] )->first();
            
            if( empty($flowProcess) ){
                throw new MsgException( 'FlowProcess not exists.' );
            }
            
            /**
             * @var \App\Models\FlowProcess $prevFlowProcess
             * @var \App\Models\FlowProcess $nextFlowProcess
             */
//             $prevFlowProcess = FlowProcess::find( [ $flowProcess->prev_flow_process_id ] )->first();
//             $nextFlowProcess = FlowProcess::find( [ $flowProcess->next_flow_process_id ] )->first();
            
//             if( $prevFlowProcess && $nextFlowProcess  ){
//                 $prevFlowProcess->next_flow_process_id = $nextFlowProcess->id;
//                 $nextFlowProcess->prev_flow_process_id = $prevFlowProcess->id;
//                 $prevFlowProcess->save();
//                 $nextFlowProcess->save();
//             }
            
            
            $taskCollection = $flowProcess->tasks()->get();
            
            Task::destroy( array_column( $taskCollection->toArray(), 'id' ) );
            
            $flowProcess->delete();
            
        });
        
        return true;
        
        
    }
    
}



?>