<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    //
    public function show($id){
        $r1 = \App\Community::find($id);
        $result = json_encode($r1);
        return $result;
    }
}
