<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\toolbox;
use Dingo\Api\Routing\Helpers;
// require_once('toolbox.php');

// this controller is for guests , no auth required...
class CommunityController extends Controller
{
    //
    use Helpers;
    public function show($id){
        $r1 = \App\Community::find($id);
        if($r1){
            $r1['icon'] = get_community_icon_path($r1['id']);
            $r1['member_count'] = get_community_member_count($id);
        }
        $r["status_code"] = 666;
        $r["community"] = $r1;
        return $r;
    }

    public function index(){
        $result = \App\Community::all();
        foreach($result as $a){
            $a['icon'] = get_community_icon_path($a['id']);
            $a['member_count'] = get_community_member_count($a['id']);
        }
        $r1["status_code"] = 666;
        $r1["communities"] = $result;
        return $r1;

    }

}
