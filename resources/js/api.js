
$(document).ready(function(){
	function API(){
		
	}
	
	API.deleteFlowProcess = function ( id ){
		$.ajax({
			url : "/flowProcess/delete",
			async : true,
			data : {
				id : id,
			},
			type : "POST",
			success : function( data ){
				msgShow( data.msg );
                
			},
			dataType : 'json'
		});
	}
	
	API.updateFlowProcess = function ( flowProcessId, name, sortNum ){
		$.ajax({
			url : "/flowProcess/update",
			async : true,
			data : {
				id : flowProcessId,
				name : name,
				sortNum : sortNum,
			},
			type : "POST",
			success : function( data ){
				msgShow( data.msg );
                
			},
			dataType : 'json'
		});
	}
	
	API.createFlowProcess = function ( flowId, prevFlowProcessId, sortNum, successFn ){
		$.ajax({
			url : "/flowProcess/create",
			async : true,
			data : {
				flowId : flowId,
				prevFlowProcessId : prevFlowProcessId,
				sortNum : sortNum,
			},
			type : "POST",
			success : function( data ){
				msgShow( data.msg );
				successFn( data );
			},
			dataType : 'json'
		});
	}
	
	API.deleteTask = function ( id ){
		$.ajax({
			url : "/task/delete",
			async : true,
			data : {
				id : id,
			},
			type : "POST",
			success : function( data ){
                msgShow( data.msg );
			},
			dataType : 'json'
		});
	}
	
	API.updateTask = function ( flowProcessId, id , name, description, deadline, sortNum, finished ){
		$.ajax({
			url : "/task/update",
			async : true,
			data : {
				flowProcessId : flowProcessId,
				id : id,
				name : name,
				description : description,
				deadline : deadline,
				sortNum : sortNum,
				finished : finished,
			},
			type : "POST",
			success : function( data ){
                msgShow( data.msg );
			},
			dataType : 'json'
		});
	}
	
	
	API.createTask = function ( flowProcessId, name, description, deadline, sortNum, successFn ){
		$.ajax({
			url : "/task/create",
			async : true,
			data : {
				flowProcessId : flowProcessId,
				name : name,
				description : description,
				deadline : deadline,
				sortNum : sortNum,
			},
			type : "POST",
			success : function( data ){
                msgShow( data.msg );
                successFn( data );
			},
			dataType : 'json'
		});
	}
	
	
	window.API = API;
	

    
    
    
    
});
