<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;
class InfoController extends Controller
{
    //
    public function getinfo(){
        $id = Auth::user()->id;
        return $id;
    }

    
}
