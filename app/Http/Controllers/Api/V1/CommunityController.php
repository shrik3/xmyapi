<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    //
    public function show($id){
        $r1 = \App\Community::find($id);
        return $r1;
    }

    public function index(){
        $result = \App\Community::all();
        return $result;

    }

}
