@extends('layouts.app')

@section('scriptYeild')
@endsection

<style>
    .textbox {
        margin: 2px !important;  
        border: 1px solid #d0d0d0 !important;
    }
    .bg-c-ec {
        background-color: #ececec;
    }
    
</style>

@section('content')
<div class="container" style="max-width:-webkit-fill-available" >
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="display: flex;overflow-x: auto;" >
                <div id='project' data-id="{{ $project->name }}" class="card-header" style="overflow-x: auto;" >Projects - {{ $project->name }}</div>

                <div class="card-body" style="display:flex; flex-direction:row; overflow-x: auto;">
                    <button id="goToProjects" type="button" class="btn-primary" style="" onclick="changeLocation('/project/all');" >view all projects</button> 
                    <button id="goToProjects" type="button" class="btn-primary" style="margin-left: 15px" onclick="window.msgShow('Done');" > save all </button> 
                    <div id="API.deleteFlowProcessArea" style="width: 300px; height: 50px; border: dashed 2px; margin-left: 15px" >
                        <div id="API.deleteTaskArea" style="width: 100%; height: 100%; text-align: center; padding-top: 4% " > drag here for deleting Flow Process or Task </div> 
					</div> 
                </div>
                
                <div class="container" style="overflow-x: auto; min-height: 900px;min-width: 1800px; " >	
                	<div id='flowContainer' data-id="{{ $flow->id }}" style="display: flex; overflow-x: auto; min-height: -webkit-fill-available; background-color: #d6d6d6; padding: 5px; margin: 10px;  border-radius: 10px;" >
                    	@php
                    		$flowProcesses = \App\Service\FlowProcessManager::sort( $flow->flowProcesses()->get() );
						@endphp
                    	@foreach ( $flowProcesses as $value )
                        	<div id='flowProcess{{ $value->id }}' data-id='{{ $value->id }}' data-sortNum='{{ $value->sort_num }}' data-mark="flowProcess" class='draggable' style="min-width: 20%;background-color: #ececec;  padding: 5px; margin: 10px; border-radius: 10px;"  >
                            	<div>{!! \App\Service\EasyUIWrapper::textBox('flowProcessNameId' . $value->id, 'flowProcessName', [ 'value' => $value->name  ], 'width:70%;', 'bg-c-ec'  ) !!}</div> 
                            	@php
                            		$tasks = \App\Service\TaskManager::sort( $value->tasks()->get() );
        						@endphp
        						@foreach ( $tasks as $v )
                                	<div id='task{{ $v->id }}' data-id='{{ $v->id }}' data-sortNum='{{ $v->sort_num }}' data-mark="task" class="draggable" style="height: 200px;background-color: #ffffff; padding: 5px; margin: 10px; border-radius: 10px;" > 
                                    	<div> <input id='finishedId{{$v->id}}' name="finished" type="checkbox" value="{{ $v->finished }}" class="" style="height: 15px; width: 15px; float:right; margin: 10px;" {{ $v->finished ? 'checked' : '' }} /> </div>
            							<div>{!! \App\Service\EasyUIWrapper::textBox('taskNameId' . $v->id, 'name', [ 'value' => $v->name  ], 'width:70%'  ) !!}</div> 
                                		
                                		<div>{!! \App\Service\EasyUIWrapper::textBox('taskDescriptionId'. $v->id, 'description', [ 'multiline' => true, 'value' => $v->description  ], 'height:120px;width:98%;'  ) !!}</div>  
                                		<div>{!! \App\Service\EasyUIWrapper::dateTimeBox('taskDeadlineId'. $v->id, 'deadline', $v->deadline, [  ], 'width:60%'  ) !!}</div>  
                                	</div>
        							
        						@endforeach
        						
                            	<div id='' data-id='' data-mark="taskCreate" class="easyui-linkbutton" data-options="iconCls:'icon-add'" style="width: 95%;height: 60px;background-color: #ffffff; padding: 5px; margin: 10px; border-radius: 10px;" > 
                            	</div>
        						
                        	</div>
						@endforeach
                    	<div id='' data-id='' data-mark="flowProcessCreate" class="easyui-linkbutton" data-options="iconCls:'icon-add'" style="display: flex; justify-content: center; align-items: center; min-width: 8%;height: auto;background-color: #ffffff;  padding: 5px; margin: 10px; border-radius: 10px;"  >

                    	</div>
                	</div>
                	
                	<div id='flowProcessTemplete' data-id='need' data-mark="flowProcess" class='draggable' style="display:none; min-width: 20%;background-color: #ececec;  padding: 5px; margin: 10px; border-radius: 10px;"  >
                    	<div><input id="fp1" name="flowProcessName" style='width:70%;' class='bg-c-ec' /></div>
                    	<div id='' data-id='' data-mark="taskCreate" class="easyui-linkbutton" data-options="iconCls:'icon-add'" style="display: flex; justify-content: center; align-items: center;width: 90%;height: 60px;background-color: #ffffff; padding: 5px; margin: 10px; border-radius: 10px;"  ></div>
            		</div>
                	
                	<div id='taskTemplete' data-id='need' data-sortNum='need' data-mark="task" class="draggable" style="display:none; height: 200px;background-color: #ffffff; padding: 5px; margin: 10px; border-radius: 10px;" > 
						<div><input id='t0' name="finished" type="checkbox" class="" style="height: 15px; width: 15px; float:right; margin: 10px;"  /> </div>
						<div><input id="t1" name="name" style='width:70%' class='' /></div>
                		<div><input id="t2" name="description" style='height:120px;width:98%;' data-options='"multiline": true' class='' /></div>  
                		<div><input id="t3" name="deadline" style='width:60%' class='' /></div>  
                	</div>
                		
                	
                
                </div>
                
				
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
	<script type="text/javascript">
		$(document).ready(function(){
			
			
			//-------------------------------------------------------------------------------------
			function registerCreateFlowProcessClickEvent(){
    			$('[data-mark="flowProcessCreate"]').on( 'click', function( event ){
    				console.log('flowProcessCreate');

					var flowId = $('#flowContainer').attr('data-id');
					var prevFlowProcessId = $(this).prev().attr('data-id') ? $(this).prev().attr('data-id') : -1;
					var sortNum = $(this).parent().find('[data-mark="flowProcess"]').length ? $(this).parent().find('[data-mark="flowProcess"]').length + 1 : 1;

					var scope = this;
					API.createFlowProcess( flowId, prevFlowProcessId, sortNum, function( data ){
        				var flowProcess = $('#flowProcessTemplete').clone()
            					.attr('id','task' + data.id )
            					.attr('data-id', data.id )
            					.css('display','');
        				$(scope).before( flowProcess );
        				EasyUIFactory.textBox( flowProcess.find("#fp1").attr('id','flowProcessNameId' + data.id ), {}, 'bg-c-ec' );
        				
        				//
        				registerFlowProcessChangeEvent();
        				registerTaskChangeEvent();
        				registerCreateTaskClickEvent();
					} );
    			});
			}
			
			function registerCreateTaskClickEvent(){
    			$('[data-mark="taskCreate"]').on( 'click', function( event ){
    				console.log($(this).parent());

					var flowProcessId = $(this).parent().attr('data-id');
    				var name = null;
    				var description = null;
    				var deadline = null;
					var sortNum = $(this).prev('[data-mark="task"]').first().attr('data-sortNum') ? $(this).prev('[data-mark="task"]').first().attr('data-sortNum') * 1 + 1 : 1;
			
					var scope = this;
					API.createTask( flowProcessId, name, description, deadline, sortNum, function( data ){
        				var task = $('#taskTemplete').clone()
        					.attr('id','task' + data.id )
        					.attr('data-id', data.id )
        					.attr('data-sortNum', data.sortNum )
        					.css('display','');
        				$(scope).before( task );
        				
        				task.find("#t0").attr( 'id', 'finishedId' + data.id );
        				EasyUIFactory.textBox( task.find("#t1").attr('id','taskNameId' + data.id ), {}, '' );
        				EasyUIFactory.textBox( task.find("#t2").attr('id','taskDescriptionId' + data.id ), { multiline: true }, ''  );
        				EasyUIFactory.dateTimeBox( task.find("#t3").attr('id','taskDeadlineId' + data.id ), { }, ''  );
        				
        				//
        				registerFlowProcessChangeEvent();
        				registerTaskChangeEvent();
					} );

    			});
			}
			
			function registerFlowProcessChangeEvent(){
    			$('[data-mark="flowProcess"]').on( 'change', function( event ){
    				if( event.originalEvent.constructor != Event ){
    					return ;
    				}
    				
    				var id = $(this).attr('data-id');
    				var name = $(event.target).val();
    				var sortNum = null;
    				
    				API.updateFlowProcess( id, name, sortNum );
    				
    				event.stopPropagation();
        				
    			} );

			}
			
			function registerTaskChangeEvent(){
    			$('[data-mark="task"]').on( 'change', function( event ){
    				if( event.originalEvent && event.originalEvent.constructor != Event ){
    					return ;
    				}
    				
    				var flowProcessId = $(this).parent().attr('data-id');
    				var id = $(this).attr('data-id');
    				var name = $(this).find( 'input[name="name"]' ).first().siblings('[id^="_easyui"]').val();
    				var description = $(this).find( 'input[name="description"]' ).first().siblings('[id^="_easyui"]').val();
    				var deadline = $(this).find( 'input[name="deadline"]' ).first().val();
    				var sortNum = null;
					var finished = $(this).find( 'input[name="finished"]' ).first().prop('checked') == true ? 1 : 0 ;
    				
    				API.updateTask( flowProcessId, id , name, description, deadline, sortNum, finished );
    				
    				event.stopPropagation();
    				
    			} );

			}

			registerCreateFlowProcessClickEvent();
			registerCreateTaskClickEvent();
			registerFlowProcessChangeEvent();
			registerTaskChangeEvent();
			
			//-------------------------------------------------------------------------
			new Sortable(document.getElementById('API.deleteFlowProcessArea'), {
    				group: 'flowContainer',
    				animation: 150,
    				fallbackOnBody: true,
    				swapThreshold: 0.65,
    				draggable: ".draggable",
			});
			
			new Sortable(document.getElementById('API.deleteTaskArea'), {
    				group: 'flowProcess',
    				animation: 150,
    				fallbackOnBody: true,
    				swapThreshold: 0.65,
    				draggable: ".draggable",
			});
			
			new Sortable(document.getElementById('flowContainer'), {
				group: 'flowContainer',
				animation: 150,
				fallbackOnBody: true,
				swapThreshold: 0.65,
				draggable: ".draggable",
				onEnd: function ( event ) {//flowProcess move

					if( $( event.to ).attr( 'id' ) == 'API.deleteFlowProcessArea' ){//delete flowProcess
						var flowProcessId = $(event.item).attr('data-id');
						
						API.deleteFlowProcess(flowProcessId);

						$(event.item).remove();
						return;
					}
					
					if( event.newIndex == event.oldIndex ){
						return ;
					}

					var flowProcessId = $(event.item).attr('data-id');
					var name = $(event.item).find('input[name="flowProcessName"]').val();
					var sortNum = event.newIndex;

					
					API.updateFlowProcess( flowProcessId, name, sortNum );
					
					
				},
			});
			
			document.querySelectorAll('[data-mark="flowProcess"]')
					.forEach( function( $value, $key ){ 			
    						new Sortable( $value, {
                				group: 'flowProcess',
                				animation: 150,
                				fallbackOnBody: true,
                				swapThreshold: 0.65,
                				draggable: ".draggable",
                				onEnd: function ( event ) {//task move
                					if( $( event.to ).attr( 'id' ) == 'API.deleteTaskArea' ){//delete task
                						var taskId = $(event.item).attr('data-id');
                						
                						API.deleteTask(taskId);

                						$(event.item).remove();
                						return;
                					}
                    				
                					if( event.constructor != CustomEvent ){
										return ;
                    				}

									if( event.from == event.to && event.oldIndex == event.newIndex ){
										return ;
									}
									console.log(event);

                    				var flowProcessId = $(event.to).attr('data-id');
                    				var id = $(event.item).attr('data-id');
                    				var name = null;
                    				var description = null;
                    				var deadline = null;
                					var sortNum = event.newIndex;
                					var finished = null;

                					API.updateTask( flowProcessId, id , name, description, deadline, sortNum, finished );
                					
                				},
    						} );
			});
			
			

		});
	</script>
@endsection

