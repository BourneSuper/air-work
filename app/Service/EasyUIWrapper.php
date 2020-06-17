<?php
namespace App\Service;


class EasyUIWrapper {
    
    public static $HTML_SCRIPT =<<<HEREDOC
<script type="text/javascript" >
    $(document).ready(function(){
        %s
    });
</script > 
HEREDOC;
    
    public static $PRINT_SCRIPT_AT_END = true;
    
    public static $SCRIPT_ARR;
    
    public static $DEFAULT_FORM_ELEMENT_CONFIG_ARR = [ 'required' => true, 'validateOnBlur' => true, 'validateOnCreate' => false ];
    
    /**
     * @param string $id
     * @param string $name
     * @param string $selectedOptionValue
     * @param array $paramArr
     * @return string
     */
    public static function comboBox( $id, $name, $selectedOptionValue = '', $paramArr = [], $style = '' ){
        $html = '<input id="%s" name="%s" value="%s" style="%s"> ';
        
        $html = sprintf( $html, $id, $name, $selectedOptionValue, $style );
        
        //
        $paramArr = array_merge( self::$DEFAULT_FORM_ELEMENT_CONFIG_ARR , $paramArr );
        
        $scriptPartStr = sprintf( '$("#%s").combobox(%s)', $id, json_encode($paramArr) );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
    }
    
    /**
     * @param string $id
     * @param string $name
     * @param array $paramArr
     * @param string $style
     * @return string
     */
    public static function textBox( $id, $name, $paramArr = [], $style = '', $cls = '' ){
        $html = '<input id="%s" name="%s" style="%s" > ';
        
        $html = sprintf( $html, $id, $name, $style );
        
        //
        $paramArr = array_merge( self::$DEFAULT_FORM_ELEMENT_CONFIG_ARR , $paramArr );

        $scriptPartStr = <<<HEREDOC
        $("#%s").textbox(%s);
        $("#%s").textbox('textbox').addClass("%s");
HEREDOC;
        
        $scriptPartStr = sprintf( $scriptPartStr, $id, json_encode($paramArr), $id, $cls );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
        
        
    }
    
    public static function dateTimeBox( $id, $name, $value, $paramArr = [], $style = '' ){
        $html = '<input id="%s" name="%s" value="%s" style="%s"> ';
        
        $html = sprintf( $html, $id, $name, $value, $style );
        
        //
        $paramArr = array_merge( self::$DEFAULT_FORM_ELEMENT_CONFIG_ARR , $paramArr );
        
        $scriptPartStr = <<<HEREDOC
var config = { 
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
config = Object.assign(config, %s);
$("#%s").datetimebox(config);
HEREDOC;
        $scriptPartStr = sprintf( $scriptPartStr, json_encode($paramArr), $id  );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
        
        
    }
    
    public static function linkButton ( $id, $name, $href, $text, $paramArr = [], $style = '' ){
        $html = '<a id="%s" name="%s" href="%s" style="%s" >%s</a> ';
        
        $html = sprintf( $html, $id, $name, $href, $style, $text );
        
        //
        $paramArr = array_merge( self::$DEFAULT_FORM_ELEMENT_CONFIG_ARR , $paramArr );
        
        $scriptPartStr = sprintf( '$("#%s").linkbutton(%s)', $id, json_encode($paramArr) );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
        
    }
    
    public static function submitButton ( $id, $name, $text, $formId, $paramArr = [], $style = '' ){
        $html = '<a id="%s" name="%s" style="%s" onclick="$(\'#%s\').submit();">%s</a> ';
        
        $html = sprintf( $html, $id, $name, $style, $formId, $text );
        
        //
        $paramArr = array_merge( self::$DEFAULT_FORM_ELEMENT_CONFIG_ARR, $paramArr );
        
        $scriptPartStr = sprintf( '$("#%s").linkbutton(%s)', $id, json_encode($paramArr) );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
        
    }
    
    /**
     * @param string $id
     * @param string $name
     * @param array $paramArr
     * @param string $style
     * @return string
     */
    public static function form( $id, $name, $paramArr = [], $style = '' ){
        $html = '';
        
        //
        $paramArr = empty($paramArr) ? new \ArrayObject : $paramArr ;
        $scriptPartStr = sprintf( '$("#%s").form(%s)', $id, json_encode($paramArr) );
        $scriptPartStr = sprintf( self::$HTML_SCRIPT, $scriptPartStr );
        
        //
        if( self::$PRINT_SCRIPT_AT_END ){
            self::$SCRIPT_ARR[] = $scriptPartStr;
        }else{
            $html .= $scriptPartStr;
        }
        
        return $html;
        
    }
    
    
    /**
     * @return string
     */
    public static function getScriptStr(){
        if( self::$PRINT_SCRIPT_AT_END ){
            if( empty( self::$SCRIPT_ARR ) ){
                return '';
            }
            
            return implode( PHP_EOL, self::$SCRIPT_ARR );
        }else{
            return '';
        }
    }
    
}

?>