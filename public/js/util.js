
$(document).ready(function(){
	window.msgShow = function ( msg, title ){
		title = title ? title : 'Message'
		$.growl.notice({ title: title, message: msg, location: 'br', size: 'large' });
//		$.messager.show({
//			title: title,
//			msg: msg,
//			timeout: 3000,
//			showType: 'fade'
//		});
	}
	
	window.msgError = function ( msg, title ){
		title = title ? title : 'Message'
		$.growl.error({ title: title, message: msg, location: 'br', size: 'large' });
	}
	
	window.msgWarning = function ( msg, title ){
		title = title ? title : 'Message'
			$.growl.warning({ title: title, message: msg, location: 'br', size: 'large' });
	}
	
    window.changeLocation = function changeLocation( pathName ){
    	window.location.href = window.location.origin + pathName;
    }
    
    window.initFrom = function initFrom( formId, pathName ){
    	$('#' + formId ).form({
            success : function( data ){
            	var data = eval('(' + data + ')');
            	msgShow( data. msg);
            	
                if( pathName ){
                	changeLocation(pathName);
                }
            }
        });
    }
    
    $.ajaxSetup({
    	headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
    });
    
    //-------------------------------------------------------
    function EasyUIFactory() { }
    
    EasyUIFactory.form = function(){
    	
    }
    
    EasyUIFactory.comboBox = function(){
    	
    }
    
    EasyUIFactory.textBox = function( $selected, config, addCls ){
    	$selected.textbox( config );
    	$selected.textbox('textbox').addClass( addCls );
    }
    
    EasyUIFactory.dateTimeBox = function( $selected, config ){
    	var tempConfig = { 
			    "onChange" : function(date){
			        $(this).trigger("change");
			    },
			    "formatter" : function (date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var h = date.getHours();
					var min = date.getMinutes();
					var sec = date.getSeconds();
					var str = y + '-' + (m<10?('0'+m):m) + '-' + (d<10?('0'+d):d) + ' ' + (h<10?('0'+h):h) + ':' + (min<10?('0'+min):min) + ':' + (sec<10?('0'+sec):sec);
					return str;
				},
			    "parser" : function (s){
					if (!s) { return new Date(); };
					var y = s.substring(0,4);
					var m = s.substring(5,7);
					var d = s.substring(8,10);
					var h = s.substring(11,13);
					var min = s.substring(14,16);
					var sec = s.substring(17,19);
			            
					if (!isNaN(y) && !isNaN(m) && !isNaN(d) && !isNaN(h) && !isNaN(min) && !isNaN(sec)){
						return new Date(y,m-1,d,h,min,sec);
					} else {
						return new Date();
					}
				}

		};
		config = Object.assign( tempConfig, config );
		$selected.datetimebox(config);
		
    }
    
    EasyUIFactory.linkButton = function(){
    	
    }
    
    EasyUIFactory.submitButton = function(){
    	
    }
    
    window.EasyUIFactory = EasyUIFactory;
    
    
    
    
});
