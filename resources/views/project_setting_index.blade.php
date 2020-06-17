@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Project Settings</div>

                <div class="card-body">
                </div>
                
                <div class="container">
                	<form id="formId" class="" action="/project/update" method="post" >
                		@csrf
                		<input name='id' value="{{ $project->id }}" hidden="hidden" />
                		name: {!! \App\Service\EasyUIWrapper::textBox('nameId', 'name', [ 'value' => $project->name ], 'width:30%'  ) !!} <br/> <br/>
                		description: {!! \App\Service\EasyUIWrapper::textBox('descriptionId', 'description', [ 'multiline' => true, 'value' => $project->description ], 'height:30%;width:30%'  ) !!} <br/> <br/>
                		owner: {!! \App\Service\EasyUIWrapper::comboBox('ownerId', 'owner', $project->owner_id, [ 'url' => '/user/optionList', 'valueField' => 'id', 'textField' => 'name' ], 'width:30%'  ) !!}<br/> <br/>
                		memebers: {!! \App\Service\EasyUIWrapper::comboBox('memberId', 'member[]', '', [ 'url' => '/user/optionList', 'multiple' => true, 'valueField' => 'id', 'textField' => 'name', 'value' => $memberIdCSVStr ], 'width:50%'  ) !!} <br/> <br/>
                		deadline: {!! \App\Service\EasyUIWrapper::dateTimeBox('deadlineId', 'deadline', $project->deadline, [  ], 'width:30%'  ) !!} <br/> <br/>
                		
                		<div style="margin-bottom: 25px;" >
                    		{!! \App\Service\EasyUIWrapper::submitButton('submitBtnId', 'submitBtn', 'update', 'formId', [  ], ''  ) !!}
                		</div>
                		
                	</form>
                </div>
    
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
	<script type="text/javascript">
		$(document).ready(function(){
			initFrom( 'formId', '/project/settingIndex/{{ $project->id }}' )
		});
	</script>
@endsection
