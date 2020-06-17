<?php
namespace App\Service;

use App\User;
class UserManager {
    
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUserIdAndName(){
        return User::all( [ 'id', 'name' ] );
    }
    

    
}

?>