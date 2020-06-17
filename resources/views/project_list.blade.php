@extends('layouts.app')

@section('scriptYeild')
<script src="{{ asset('js/home.js') }}" ></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Projects</div>

                <div class="card-body">
                    <button id="goToProjects" type="button" class="btn-primary" onclick="changeLocation('/project/all');" >view all projects</button> 
                    <button id="asOwner" type="button" class="btn-primary" onclick="changeLocation('/project/asOwner');" >view as owner</button> 
                    <button id="asMember" type="button" class="btn-primary" onclick="changeLocation('/project/asMember');" >view as member</button> 
                    <button id="create" type="button" class="btn-primary" onclick="changeLocation('/project/createIndex');" >create</button> 
                </div>
                
                <div class="container">
                	{{ $paginator->links() }} per page: {{ $paginator->perPage() }} total: {{ $paginator->total()  }}
                	<table class="table" >
                		<thead>
                			<tr>
                				<th> ID </th>
                				<th> name </th>
                				<th class="w-40" > description </th>
                				<th> deadline </th>
                				<th> owner name </th>
                				<th> create time </th>
                				<th> operation </th>
                			</tr>
                		</thead>
                    	<tbody>
                            @foreach ($paginator as $value)
                        		<tr>
                                    <td> {{ $value->id }} </td>
                                    <td> {{ $value->name }} </td>
                                    <td> {{ $value->description }} </td>
                                    <td> {{ $value->deadline }} </td>
                                    <td> {{ $value->owner_name }} </td>
                                    <td> {{ $value->created_at }} </td>
                                    <td> 
                                    	<button id="settingsBtn" type="button" class="btn-primary" style="margin: 5px;" onclick="changeLocation('/project/settingIndex/{{ $value->id }}');" > settings </button> 
                                    	<button id="goToProjects" type="button" class="btn-primary" style="margin: 5px;" onclick="changeLocation('/project/boardIndex/{{ $value->id }}');" > board </button> 
                                	</td>
                                </tr>
                            @endforeach
                    	</tbody>
                    </table>
            		{{ $paginator->links() }} per page: {{ $paginator->perPage() }} total: {{ $paginator->total()  }}
                </div>
    
				
                
            </div>
        </div>
    </div>
</div>
@endsection

