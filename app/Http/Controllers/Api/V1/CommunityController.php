<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\toolbox;
use Dingo\Api\Routing\Helpers;
require_once('toolbox.php');
class CommunityController extends Controller
{
    //
    use Helpers;
    public function show($id){
        $r1 = \App\Community::find($id);
        if($r1){
            $r1['icon'] = get_community_icon_path($r1['id']);
        }
        return $r1;
    }

    public function index(){
        $result = \App\Community::all();
        foreach($result as $a){
            $a['icon'] = get_community_icon_path($a['id']);
        }
        return $result;

    }

}
