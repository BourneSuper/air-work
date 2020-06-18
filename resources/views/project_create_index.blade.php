@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Project</div>

                <div class="card-body">
                	<button id="goToProjects" type="button" class="btn-primary" style="" onclick="changeLocation('/project/all');" >view all projects</button>
                </div>
                
                <div class="container">
                	<form id="formId" class="" action="/project/create" method="post" >
                		@csrf
                		name: {!! \App\Service\EasyUIWrapper::textBox('nameId', 'name', [  ], 'width:30%'  ) !!} <br/> <br/>
                		description: {!! \App\Service\EasyUIWrapper::textBox('descriptionId', 'description', [ 'multiline' => true,  ], 'height:30%;width:30%'  ) !!} <br/> <br/>
                		owner: {!! \App\Service\EasyUIWrapper::comboBox('ownerId', 'owner', \Auth::id(), [ 'url' => '/user/optionList', 'valueField' => 'id', 'textField' => 'name' ], 'width:30%'  ) !!}<br/> <br/>
                		memebers: {!! \App\Service\EasyUIWrapper::comboBox('memberId', 'member[]', '', [ 'url' => '/user/optionList', 'multiple' => true, 'valueField' => 'id', 'textField' => 'name' ], 'width:50%'  ) !!} <br/> <br/>
                		deadline: {!! \App\Service\EasyUIWrapper::dateTimeBox('deadlineId', 'deadline', '', [  ], 'width:30%'  ) !!} <br/> <br/>
                		
                		<div style="margin-bottom: 25px;" >
                			{!! \App\Service\EasyUIWrapper::submitButton('submitBtnId', 'submitBtn', 'create', 'formId', [  ], ''  ) !!}
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
			initFrom( 'formId', '/project/asOwner' )
		});
	</script>
@endsection
