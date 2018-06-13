<?php
// This controller is for community management , auth required .. 
namespace App\Http\Controllers\Api\V1\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;
class CommunityController extends Controller
{
    use Helpers;
    //


    public function join($id){
        $user_id = Auth::user()->id;
        if(!\App\Community::find($id)){
            return $this->response->array(['status_code'=>501 , "message"=>"community doesn't exist"]);
        }
        if(\App\Membership::select()->where("member_id","=",$user_id)
                                          ->where("community_id","=",$id)
                                          ->count()){
                                              return $this->response->array(['status_code'=>701 , "message"=>"already a member"]);
                                          }
        $r = new \App\Membership;
        $r->community_id = $id;
        $r->member_id = $user_id;
        $r->role = "2";
        if(!$r->save()){
            return $this->response->array(['status_code'=>101 , "message"=>"failed"]);
        }
        return $this->response->array(['status_code'=>666 , "message"=>"success"]);

    }



    public function icon(Request $request){
        // $content = $request->getContent();
        // // 检测是否为 json 数据
        // if (is_not_json($content)) {
        //     // $this->response->errorBadRequest('this is not json , fuck you');
        //     return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
        // }
        // // json 数据解码
        // $data = json_decode($content, true);

        // 鉴别用户权限：这里可以改成user模型里的一对多关系。
        $user_id = Auth::user()->id;
        $com_id = $request->get("id");
        if(!\App\Community::find($com_id)){
            return $this->response->array(['status_code'=>501 , "message"=>"community doesn't exist"]);
        }
        $role =  get_user_role($user_id,$com_id);
        if($role>2){
            return $this->response->array(['status_code'=>502 , "message"=>"you are not allowed to do that"]);
        }else{
            // CORE CODE ...


             $newImage = \App\Photo::where("type","=","CommunityIcon")
                                ->where("owner_id","=",$com_id)->first();
        
        
            if(!$newImage){
                 $newImage = new \App\Photo;
            }    
        
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $newImage->title = $request->get('name').'icon';
            $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
            $newImage->type = 'CommunityIcon';
            $request->image->move(public_path('images'), $newImage->file_name);
    
    
            $newImage->owner_id =  $com_id;
            if (!$newImage->save()) {
                return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
            }
    
                return $this->response->array(['status_code'=>666 , "id"=>$com_id, "message"=>"success"]);
        }

    }

    public function create(Request $request){
        $content = $request->getContent();
        // 检测是否为 json 数据
        if (is_not_json($content)) {
            // $this->response->errorBadRequest('this is not json , fuck you');
            return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
        }
        // json 数据解码
        $data = json_decode($content, true);

        if (\App\Community::where('name', $data['name'])->count() > 0) {
            // $this->response->errorBadRequest('user name is already taken');
            return $this->response->array(['status_code'=>507 , "message"=>"name already taken"]);
        }

        $com = new \App\Community();
        $mem = new \App\Membership();

        $userid = Auth::user()->id;
        $com->name= $data['name'];
        $com->brief = $data['brief'];
        if ($com->save()){
            $mem->community_id = $com->id ;
            $mem->member_id = $userid ;
            $mem->role = 0;
            if($mem->save()){
                return $this->response->array(['status_code'=>666 , "id"=>$com->id, "message"=>"success"]);
            }
            $mem->delete();
            $com->delete();
            return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        }
        return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        $mem->delete();
        $com->delete();
    }
}
