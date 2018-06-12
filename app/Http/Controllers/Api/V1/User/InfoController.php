<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;
// include "../toolbox.php";


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
            // $this->response->errorBadRequest('this is not json , fuck you');
            return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
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

    public function change_icon(Request $request){
        $user_id = Auth::user()->id;
        $this->validate($request , [
            'image'=> 'required|image|mimes:jpeg,png,jpt,gif,svg|max:2048',
        ]);

        $newImage = new \App\Photo;
        $newImage->title = "icon";
        $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
        $newImage->type = "UserIcon";
        $newImage->owner_id = $user_id;
        $request->image->move(public_path('images'), $newImage->file_name);
        if (!$newImage->save()) {
            return $this->response->array(['status_code'=>101 , "message"=>"unsaved"]);

        }
            return $this->response->array(['status_code'=>666 , "message"=>"saved"]);
    }
    
}
