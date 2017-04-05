<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    //
    public function show($id){
        $r1 = \App\Community::find($id);
        return $result;
    }

    public function index(){
        $result = \App\Community::all();
        return $result;

    }

}
