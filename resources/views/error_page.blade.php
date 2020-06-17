@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Project</div>

<!--                 <div class="card-body"> -->
<!--                 </div> -->
                
                <div class="container">
					<div style="margin: 20px;" >
						<font style="color: red ;" size="10" >{{ $msg }}</font> <br/>
						<a class="easyui-linkbutton" data-options="iconCls:'icon-back'" onclick="window.history.go(-1);">go back</a>
					</div>
                </div>
    
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection
