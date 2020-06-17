<?php
namespace App\Service;

use App\Models\Task;
use App\Models\FlowProcess;
class TaskManager {
    
    /**
     * @param \Illuminate\Database\Eloquent\Collection $flowProcessCollection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sort( $taskCollection ){
        return $taskCollection->sortBy( function ( $value, $key ){
            return $value->sort_num;
        } );
    
    }
    
    /**
     * @param int $flowProcessId
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $deadline
     * @param int $sortNum
     * @throws MsgException
     * @return boolean
     */
    public function update( $flowProcessId, $id, $name, $description, $deadline, $sortNum, $finished ){
        
        /**
         * @var \App\Models\FlowProcess $flowProcess
         */
        $flowProcess = FlowProcess::find( [ $flowProcessId ] )->first();
        
        if( empty($flowProcess) ){
            throw new MsgException( 'FlowProcess not exists.' );
        }
        
        /**
         * @var \App\Models\Task $task
         */
        $task = Task::find( [ $id ] )->first();
        
        if( empty($task) ){
            throw new MsgException( 'Task not exists.' );
        }
        
        $oldSortNum = $task->sort_num;
        $oldFlowProcessId = $task->flow_process_id;
        
        $task->flow_process_id = $flowProcessId;
        $name === null ? '' : $task->name = $name;
        $description === null ? '' : $task->description = $description;
        $deadline === null ? '' : $task->deadline = $deadline;
        $sortNum === null ? '' : $task->sort_num = $sortNum ;
        $finished === null ? '' : $task->finished = $finished ;
        
        \DB::transaction( function() use ( $task, $oldSortNum, $sortNum, $oldFlowProcessId, $flowProcessId ) {
                if( !empty( $sortNum ) ){
                    if( $oldFlowProcessId == $flowProcessId ){//move in current Flow Process
                        if( $oldSortNum < $sortNum ){
                                \DB::table('tasks')
                                    ->where( 'flow_process_id', $task->flow_process_id )
                                    ->where( 'sort_num', '>', $oldSortNum )
                                    ->where( 'sort_num', '<=', $sortNum )
                                    ->where( 'id', '!=', $task->id )
                                    ->decrement( 'sort_num' );
                        }
                    
                        if( $oldSortNum > $sortNum  ){
                                \DB::table('tasks')
                                    ->where( 'flow_process_id', $task->flow_process_id )
                                    ->where( 'sort_num', '>=', $sortNum )
                                    ->where( 'sort_num', '<', $oldSortNum )
                                    ->where( 'id', '!=', $task->id )
                                    ->increment( 'sort_num' );
                        }
                        
                    }else{//move across Flow Process
                        \DB::table('tasks')
                                ->where( 'flow_process_id', $oldFlowProcessId )
                                ->where( 'sort_num', '>', $oldSortNum )
                                ->decrement( 'sort_num' );
                        
                        \DB::table('tasks')
                            ->where( 'flow_process_id', $task->flow_process_id )
                            ->where( 'sort_num', '>=', $sortNum )
                            ->where( 'id', '!=', $task->id )
                            ->increment( 'sort_num' );
                    }
                    
                }
                
                $task->save();
        } );
        
        
        
        return true;
        
    }
    
    /**
     * @param int $flowProcessId
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $deadline
     * @param int $sortNum
     * @throws MsgException
     * @return \App\Models\Task
     */
    public function create( $flowProcessId, $name, $description, $deadline, $sortNum ){
        
        /**
         * @var \App\Models\FlowProcess $flowProcess
         */
        $flowProcess = FlowProcess::find( [ $flowProcessId ] )->first();
        
        if( empty($flowProcess) ){
            throw new MsgException( 'FlowProcess not exists.' );
        }
        /**
         * @var \App\Models\Task $task
         */
        $task = new Task();
        
        $task->project_id = $flowProcess->project_id;
        $task->flow_process_id = $flowProcessId;
        $name === null ? '' : $task->name = $name;
        $description === null ? '' : $task->description = $description;
        $deadline === null ? '' : $task->deadline = $deadline;
        $sortNum === null ? '' : $task->sort_num = $sortNum ;
        $task->creator_id = \Auth::id();
        
        $task->save();
        
        return $task;
        
    }
    
    /**
     * @param int $id
     */
    public function delete( $id ){
        /**
         * @var \App\Models\Task $task
         */
        $task = Task::find( [ $id ] )->first();
        
        if( empty($task) ){
            throw new MsgException( 'Task not exists.' );
        }
        
        $task->delete();
        
        return true;
        
    }
    
    
}

?>