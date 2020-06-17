<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use App\Models\FlowProcess;
use App\Models\Task;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $userCollection = factory( \App\User::class, 15 )->create();
        $userCollection->first()->name = 'zhangsan';
        $userCollection->first()->email = 'zhangsan@zhangsan.com';
        $userCollection->first()->password = Hash::make('zhangsan');
        
        /**
         * @var \App\Models\Project $project
         */
        $project = factory( \App\Models\Project::class, 1 )->make()->first();
        $project->owner_id = $userCollection->first()->id;
        $project->owner_name = $userCollection->first()->name;
        $project->flow_id = 0;
        
        $project->save();
        
        //
        $project->members()->saveMany( $userCollection );

        //
        /**
         * @var \App\Models\Flow $flow
         */
        $flow = $project->flow()->create();
        
        //
        /**
         * @var \App\Models\FlowProcess $flowProcess1
         * @var \App\Models\FlowProcess $flowProcess2
         */
        $flowProcess1 = factory( \App\Models\FlowProcess::class, 1 )->make()->first();
        $flowProcess2 = factory( \App\Models\FlowProcess::class, 1 )->make()->first();
        
        $flowProcess1->project_id = $project->id;
        $flowProcess1->flow_id = $flow->id;
//         $flowProcess1->prev_flow_process_id = 0;
//         $flowProcess1->next_flow_process_id = 0;
        $flowProcess1->sort_num = 1;
        
        
        $flowProcess1->save();
        
        $flowProcess2->project_id = $project->id;
        $flowProcess2->flow_id = $flow->id;
//         $flowProcess2->prev_flow_process_id = $flowProcess1->id;
//         $flowProcess2->next_flow_process_id = 0;
        $flowProcess2->sort_num = 2;
        $flowProcess2->save();
        
//         $flowProcess1->next_flow_process_id = $flowProcess2->id;
        $flowProcess1->save();
        
        /**
         * @var \App\Models\Task $task1
         */
        $task1 = factory( \App\Models\Task::class, 1 )->make()->first();
        $task1->project_id = $project->id;
        $task1->flow_process_id = $flowProcess1->id;
        $task1->sort_num = 1;
        $task1->finished = 1;
        $task1->creator_id = $userCollection->first()->id;
        
        /**
         * @var \App\Models\Task $task2
         */
        $task2 = factory( \App\Models\Task::class, 1 )->make()->first();
        $task2->project_id = $project->id;
        $task2->flow_process_id = $flowProcess1->id;
        $task2->sort_num = 2;
        $task2->finished = 1;
        $task2->creator_id = $userCollection->first()->id;
        
        /**
         * @var \App\Models\Task $task3
         */
        $task3 = factory( \App\Models\Task::class, 1 )->make()->first();
        $task3->project_id = $project->id;
        $task3->flow_process_id = $flowProcess2->id;
        $task3->sort_num = 3;
        $task3->creator_id = $userCollection->first()->id;
        
        $flowProcess1->tasks()->saveMany( [ $task1, $task2 ] );
        $flowProcess2->tasks()->saveMany( [ $task3 ] );
        
        $flow->flowProcesses()->saveMany( new Collection( [ $flowProcess1, $flowProcess2 ] ) );
        
        //
        $project->flow()->save( $flow );
        
        //
        $projectCollection = $this->generateRandomProject();
        $taskCollection = $this->generateRandomTask();
        $flowProcessCollection = $this->generateRandomFlowProcess();
        $flowCollection = $this->generateRandomFlow();
        
        $this->assembleProjectPart( $projectCollection, $taskCollection, $flowProcessCollection, $flowCollection );
    }
    
    public function generateRandomProject(){
        return factory( \App\Models\Project::class, 30 )->make()->each( function( $item, $key ){
            if( $key <= 15 ){
                $item->owner_id = 1;
                $item->owner_name = 'zhangsan';
            }
            $item->save();
        } );
    }
    
    public function generateRandomTask(){
        return factory( \App\Models\Task::class, 480 )->create();
    }
    
    public function generateRandomFlowProcess(){
        return factory( \App\Models\FlowProcess::class, 120 )->create();
    }
    
    public function generateRandomFlow(){
        return factory( \App\Models\Flow::class, 30 )->create();
    }
    
    public function assembleProjectPart( 
            \Illuminate\Database\Eloquent\Collection $projectCollection, 
            \Illuminate\Database\Eloquent\Collection $taskCollection, 
            \Illuminate\Database\Eloquent\Collection $flowProcessCollection, 
            \Illuminate\Database\Eloquent\Collection $flowCollection ){
        //
        $projectCount = $projectCollection->count();
        $FPCollectionArr = [];
        $taskCollectionArr = [];
        for( $i = 0; $i < $projectCount; $i++ ){
            $randCount = rand( 1, 5 );
            
            $tempFPArr = [];
            for ( $j = 0; $j < $randCount; $j++ ){
                $tempFPArr[] = $flowProcessCollection->shift();
                
                $tempTaskArr = [];
                for ( $k = 0; $k < $randCount; $k++ ){
                    $tempTaskArr[] = $taskCollection->shift();
                }
                $taskCollectionArr[] = $tempTaskArr;
                
            }
            $FPCollectionArr[] = $tempFPArr;
        }
        
        //
        FlowProcess::destroy($flowProcessCollection);
        Task::destroy($taskCollection);
        
        
        //
        /**
         * @var \App\Models\Project $item
         */
        $projectCollection->each( function( $item, $key ) use( 
                $FPCollectionArr, $taskCollectionArr, $flowCollection ) {
            
            /**
             * @var \App\Models\Flow $flow
             */
            $flow = $flowCollection->shift();
            $flow->project_id = $item->id;
            $flow->save();
            
            $item->flow_id = $flow->id;
            $item->save();
            
            $tempFPArr = $FPCollectionArr[$key];
            $tempTaskArr = $taskCollectionArr[$key];
            
            for ( $i = 0; $i < count($tempFPArr); $i++ ){
                /**
                 * @var \App\Models\FlowProcess $fp
                 */
                $fp = $tempFPArr[$i];
                $fp->project_id = $item->id;
                $fp->flow_id = $flow->id;
//                 if( $i == 0 ){
//                     $fp->prev_flow_process_id = -1;
//                 } else {
//                     $fp->prev_flow_process_id = $tempFPArr[ $i - 1 ]->id;
//                 }
                
//                 if( $i == ( count($tempFPArr) - 1 ) ){
//                     $fp->next_flow_process_id = -1;
//                 }else{
//                     $fp->next_flow_process_id = $tempFPArr[ $i + 1 ]->id;
//                 }
                
                $fp->sort_num = $i;
                
                for ( $j = 0; $j < count($tempTaskArr); $j++ ){
                    /**
                     * @var \App\Models\Task $task
                     */
                    $task = $tempTaskArr[ $j ];
                    $task->project_id = $item->id;
                    $task->flow_process_id = $fp->id;
                    $task->sort_num = $j;
                    
                    $task->save();
                }
                
                $fp->save();
                
            }
            
        } );
        
        FlowProcess::where( [ 'project_id' => 0 ] )->delete();
        Task::where( [ 'project_id' => 0 ] )->delete();
        
    }
    
    
    
}
