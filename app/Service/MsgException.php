<?php
namespace App\Service;

class MsgException extends \Exception{
    
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report(){
        //
    }
    
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render( $request ){
        
        return response( \View::make( 'error_page', [ 'msg' => $this->getMessage() ] ) );
    }
    
}

?>