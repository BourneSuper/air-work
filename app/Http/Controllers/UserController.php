<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use App\Service\UserManager;
use App\Service\Util;

class UserController extends Controller {
    
    public function optionList(){
        $userManager = new UserManager();
        $userIdAndNameCollection =  $userManager->getAllUserIdAndName();
        
        return \Response::json( $userIdAndNameCollection );
        
    }
    
}
