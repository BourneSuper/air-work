<?php
namespace App\Service;

use App\Models\Project;
use App\Models\Flow;
use App\Models\FlowProcess;
use App\Models\Task;
class FlowManager {
    
    
    /**
     * @return \App\Models\Flow
     */
    public function createDevelopeFLow( $projectId ){
        $flow = null;
        
        /**
         * @var \App\Models\Project $project
         */
        $project = Project::find( [ $projectId ] )->first();
        
        if( !$project ){
            throw new MsgException( 'Project not exists.' );
        }
        
        \DB::transaction( function () use( $project, $flow ) {
            /**
             * @var \App\Models\Flow $flow
             */
            $flow = new Flow();
            $flow->project_id = $project->id;
            $flow->save();
            
            //
            $project->flow_id = $flow->id;
            $project->save();
            
            //
            $flowProcess1 = new FlowProcess();
            $flowProcess1->project_id = $project->id;
            $flowProcess1->flow_id = $flow->id;
            $flowProcess1->name = "Flow Process Name / 【流程】名";
            $flowProcess1->description = '';
            $flowProcess1->sort_num = 0;
            $flowProcess1->save();
            
            $task11 = new Task();
            $task11->project_id = $project->id;
            $task11->creator_id = \Auth::id();
            $task11->flow_process_id = $flowProcess1->id;
            $task11->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task11->name = "Task Name / 【任务】名";
            $task11->description = "Task Description " . PHP_EOL . " 任务内容";
            $task11->sort_num = 1;
            $task11->save();
            
            $task12 = new Task();
            $task12->project_id = $project->id;
            $task12->creator_id = \Auth::id();
            $task12->flow_process_id = $flowProcess1->id;
            $task12->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task12->name = "Another Task Name / 另一个任务名";
            $task12->description = "Another Task Description " . PHP_EOL . " 另一个任务内容";
            $task12->sort_num = 2;
            $task12->save();
            
            $task13 = new Task();
            $task13->project_id = $project->id;
            $task13->creator_id = \Auth::id();
            $task13->flow_process_id = $flowProcess1->id;
            $task13->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task13->name = "Sort Task / 排序任务";
            $task13->description = "Sort task by Dragging and dropping task in current Flow Process  " . PHP_EOL . " 在当前【流程】中拖动【任务】进行排序";
            $task13->sort_num = 3;
            $task13->save();
            
            $task14 = new Task();
            $task14->project_id = $project->id;
            $task14->creator_id = \Auth::id();
            $task14->flow_process_id = $flowProcess1->id;
            $task14->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task14->name = "Move Task / 移动任务";
            $task14->description = "Move task by Dragging task and dropping task in other Flow Process " . PHP_EOL . " 拖动【任务】到其他【流程】中进行任务移动";
            $task14->sort_num = 4;
            $task14->save();
            
            //
            $flowProcess2 = new FlowProcess();
            $flowProcess2->project_id = $project->id;
            $flowProcess2->flow_id = $flow->id;
            $flowProcess2->name = "Another Flow Process Name / 另一个【流程】名";
            $flowProcess2->description = '';
            $flowProcess2->sort_num = 1;
            $flowProcess2->save();
            
            $task21 = new Task();
            $task21->project_id = $project->id;
            $task21->creator_id = \Auth::id();
            $task21->flow_process_id = $flowProcess2->id;
            $task21->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task21->name = "Create Task / 创建任务";
            $task21->description = "Create task by clicking horizontal Create Button  " . PHP_EOL . " 点击创建按钮创建【任务】";
            $task21->sort_num = 1;
            $task21->save();
            
            $task22 = new Task();
            $task22->project_id = $project->id;
            $task22->creator_id = \Auth::id();
            $task22->flow_process_id = $flowProcess2->id;
            $task22->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task22->name = "Delete Task / 删除任务";
            $task22->description = "Delelte task by drag task to the Deleting Area at the top " . PHP_EOL . " 把【任务】拖到删除区域进行删除";
            $task22->sort_num = 2;
            $task22->save();
            
            $task23 = new Task();
            $task23->project_id = $project->id;
            $task23->creator_id = \Auth::id();
            $task23->flow_process_id = $flowProcess2->id;
            $task23->deadline = date( 'Y-m-d H:i:s', strtotime('+30 days') );
            $task23->name = "Flow Process / 流程的使用";
            $task23->description = "Using Flow Process is same way as using Task " . PHP_EOL . " 【流程】的使用方法和【任务】使用方法一样 ";
            $task23->sort_num = 3;
            $task23->save();
            
            //
            $flowProcess3 = new FlowProcess();
            $flowProcess3->project_id = $project->id;
            $flowProcess3->flow_id = $flow->id;
            $flowProcess3->name = "Requirement Gather / 需求收集";
            $flowProcess3->description = '';
            $flowProcess3->sort_num = 2;
            $flowProcess3->save();
            
            $flowProcess4 = new FlowProcess();
            $flowProcess4->project_id = $project->id;
            $flowProcess4->flow_id = $flow->id;
            $flowProcess4->name = "Requirement Analysis / 需求分析";
            $flowProcess4->description = '';
            $flowProcess4->sort_num = 3;
            $flowProcess4->save();
            
            $flowProcess5 = new FlowProcess();
            $flowProcess5->project_id = $project->id;
            $flowProcess5->flow_id = $flow->id;
            $flowProcess5->name = "Architecture / 架构";
            $flowProcess5->description = '';
            $flowProcess5->sort_num = 4;
            $flowProcess5->save();
            
            $flowProcess6 = new FlowProcess();
            $flowProcess6->project_id = $project->id;
            $flowProcess6->flow_id = $flow->id;
            $flowProcess6->name = "Design / 设计";
            $flowProcess6->description = '';
            $flowProcess6->sort_num = 5;
            $flowProcess6->save();
            
            $flowProcess7 = new FlowProcess();
            $flowProcess7->project_id = $project->id;
            $flowProcess7->flow_id = $flow->id;
            $flowProcess7->name = "Implement / 实现";
            $flowProcess7->description = '';
            $flowProcess7->sort_num = 6;
            $flowProcess7->save();
            
            $flowProcess8 = new FlowProcess();
            $flowProcess8->project_id = $project->id;
            $flowProcess8->flow_id = $flow->id;
            $flowProcess8->name = "Test / 测试";
            $flowProcess8->description = '';
            $flowProcess8->sort_num = 7;
            $flowProcess8->save();
            
            $flowProcess9 = new FlowProcess();
            $flowProcess9->project_id = $project->id;
            $flowProcess9->flow_id = $flow->id;
            $flowProcess9->name = "Deployment / 部署";
            $flowProcess9->description = '';
            $flowProcess9->sort_num = 8;
            $flowProcess9->save();
            
            //
            $flowProcessArr = /* self::makeDoubleLink( */ [ 
                $flowProcess1, $flowProcess2, $flowProcess3, $flowProcess4,
                $flowProcess5, $flowProcess6, $flowProcess8, $flowProcess9,
            ] /* ) */;
            
            $flow->flowProcesses()->saveMany( $flowProcessArr );
            
        } );
        
        return $flow;
    }
    
    
    /**
     * 
     * @param \App\Models\FlowProcess[] $flowProcessArr
     * @return \App\Models\FlowProcess[] $flowProcessArr
     */
    public static function makeDoubleLink( $flowProcessArr ){
        
//         $totalNum = count( $flowProcessArr );
        
//         for( $i = 0; $i < $totalNum; $i++ ){
//             /**
//              * @var \App\Models\FlowProcess $fp
//              */
//             $fp = $flowProcessArr[$i];
//             if( $i == 0 ){
//                 $fp->prev_flow_process_id = -1;
//             } else {
//                 $fp->prev_flow_process_id = $flowProcessArr[ $i - 1 ]->id;
//             }
            
//             if( $i == ( count($flowProcessArr) - 1 ) ){
//                 $fp->next_flow_process_id = -1;
//             }else{
//                 $fp->next_flow_process_id = $flowProcessArr[ $i + 1 ]->id;
//             }
//         }
        
        return $flowProcessArr;
    }
    
    
}

?>