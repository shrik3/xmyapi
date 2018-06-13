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

    public function mygroups(){
        $id = Auth::user()->id;
        $communities = \App\Membership::select()->where("member_id","=",$id)
                                                  ->where("role","<=",3)->get();
        $circles = \App\CircleMembership::select()->where("member_id","=",$id)
                                                  ->where("role","<=",3)->get();

        $r1 = [];
        $r2 = [];

        foreach ($communities as $com){
            $com_id = $com["community_id"];
            $info = \App\Community::find($com_id);
            $info["my_role"] = get_member_role($com["role"]);
            $info["type"] = "community";
            $info["member_count"] = get_community_member_count($com_id);
            array_push($r1, $info);
        }
 
        foreach ($circles as $cir){
            $cir_id = $cir["circle_id"];
            $info = \App\Circle::find($cir_id);
            $info["my_role"] = get_member_role($cir["role"]);
            $info["type"] = "circle";
            $info["member_count"] = get_circle_member_count($cir_id);
            array_push($r2, $info);
 
        }

        $result["status_code"] = 666;
        $result["communities"] = $r1 ;
        $result["circles"] = $r2;
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

        $newImage = \App\Photo::where("type","=","UserIcon")
                                ->where("owner_id","=",$user_id)->first();
        
        
        if(!$newImage){
            $newImage = new \App\Photo;
        }    
        

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
    
    public function footprints(){
        $uid = Auth::user()->id;
        $written = get_user_written_articles($uid);
        $commented = get_user_commented_articles($uid);

        $result['status_code'] = 666;
        $result['commented'] = $commented;
        $result['written'] = $written;
        return $result;
    }
}
