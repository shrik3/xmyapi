<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    //
    public function show($id){
        $r1 = \App\Community::find($id);
        if($r1){
            $r1['icon'] = url('/images/unnamed.png');
        }
        return $r1;
    }

    public function index(){
        $result = \App\Community::all();
        foreach($result as $a){
            $a['icon'] = url('/images/unnamed.png');
        }
        return $result;

    }

}
