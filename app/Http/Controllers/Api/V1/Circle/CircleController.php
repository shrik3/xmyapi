<?php

namespace App\Http\Controllers\Api\V1\Circle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;

class CircleController extends Controller
{
    //
    use Helpers;

    public function join($id){
        $user_id = Auth::user()->id;
        if(!\App\Circle::find($id)){
            return $this->response->array(['status_code'=>501 , "message"=>"circle doesn't exist"]);
        }
        if(\App\CircleMembership::select()->where("member_id","=",$user_id)
                                          ->where("circle_id","=",$id)
                                          ->count()){
                                              return $this->response->array(['status_code'=>701 , "message"=>"already a member"]);
                                          }
        $r = new \App\CircleMembership;
        $r->circle_id = $id;
        $r->member_id = $user_id;
        $r->role = "2";
        if(!$r->save()){
            return $this->response->array(['status_code'=>101 , "message"=>"failed"]);
        }
        return $this->response->array(['status_code'=>666 , "message"=>"success"]);

    }


    public function show($id){
        $r1 = \App\Circle::find($id);
        if($r1){
            $r1['icon'] = get_circle_icon_path($r1['id']);
        }
        $r["status_code"] = 666;
        $r["circle"] = $r1;
        return $r;
    }

    public function index(){
        $result = \App\Circle::all();
        foreach($result as $a){
            $a['icon'] = get_circle_icon_path($a['id']);
        }
        $r1["status_code"] = 666;
        $r1["circle"] = $result;
        return $r1;

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
        $cir_id = $request->get("id");
        if(!\App\Circle::find($cir_id)){
            return $this->response->array(['status_code'=>501 , "message"=>"circle doesn't exist"]);
        }
        $role =  get_circle_user_role($user_id,$cir_id);
        if($role>2){
            return $this->response->array(['status_code'=>502 , "message"=>"you are not allowed to do that"]);
        }else{
            // CORE CODE ...


            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
                

            $newImage = \App\Photo::where("type","=","CircleIcon")
                                ->where("owner_id","=",$cir_id)->first();
        
        
            if(!$newImage){
                 $newImage = new \App\Photo;
            }    

            $newImage->title = $request->get('name').'icon';
            $newImage->file_name = time().'.'.$request->image->getClientOriginalExtension();
            $newImage->type = 'CircleIcon';
            $request->image->move(public_path('images'), $newImage->file_name);
    
    
            $newImage->owner_id =  $cir_id;
            if (!$newImage->save()) {
                return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
            }
    
                return $this->response->array(['status_code'=>666 , "id"=>$cir_id, "message"=>"success"]);
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

        if (\App\Circle::where('name', $data['name'])->count() > 0) {
            // $this->response->errorBadRequest('user name is already taken');
            return $this->response->array(['status_code'=>507 , "message"=>"name already taken"]);
        }

        $cir = new \App\Circle();
        $mem = new \App\CircleMembership();

        $userid = Auth::user()->id;
        $cir->name= $data['name'];
        $cir->brief = $data['brief'];
        if ($cir->save()){
            $mem->circle_id = $cir->id ;
            $mem->member_id = $userid ;
            $mem->role = 0;
            if($mem->save()){
                return $this->response->array(['status_code'=>666 , "id"=>$cir->id, "message"=>"success"]);
            }
            $mem->delete();
            $cir->delete();
            return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        }
        return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        $mem->delete();
        $cir->delete();
    }
}
