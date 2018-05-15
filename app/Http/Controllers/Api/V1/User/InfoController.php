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

    private function get_icon_path($id) {
        $icon = \App\Photo::select('file_name')
            ->where([
                'owner_id' => $id,
                'type' => 'UserIcon'
            ])
            ->first();
        $url = url('images/' . $icon['file_name']);
        return $url;
    }

    public function getinfo(){
        $id = Auth::user()->id;
        $user = \App\User::find($id);
        $result = [];
        $result["name"] = $user->name;
        $result["email"] = $user->email;
        $result["IconUrl"] = $this->get_icon_path($id);
        $result["id"] = $user->id;

        $result["status_code"] = 666;

        return $result;
    }

    
}
