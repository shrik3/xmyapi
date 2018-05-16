<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;
require_once("toolbox.php");


class InfoController extends Controller
{
    //
    use Helpers;

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

    public function change_nickname(Request $request){

        $content = $request->getContent();
        // 检测是否为 json 数据
        if (is_not_json($content)) {
            $this->response->errorBadRequest('this is not json , fuck you');
        }
        // json 数据解码
        $data = json_decode($content, true);

        $nickname = $data['nickname'];
        $id = Auth::user()->id;
        $user = \App\User::find($id);
        $user->nickname = $nickname;
        if($user->save()){
            $result = [];
            $result["name"] = $user->name;
            $result["nicknamef"] = $user->nickname;
            $result["email"] = $user->email;
            $result["IconUrl"] = $this->get_icon_path($id);
            $result["id"] = $user->id;
            $result["status_code"] = 666;
            return $result;
        }
    }
    
}
