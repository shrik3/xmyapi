<?php

namespace App\Http\Controllers\Api\V1\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Auth;


class ArticleController extends Controller
{
    //
    use helpers;


    public function like($id){
        \DB::table("articles")->where("id",$id)->increment("likes");
        return $this->response->array(['status_code'=>666 ,  "message"=>"success"]);

    }

    public function index(){
        $list = \App\Article::orderBy("created_at",'desc')->get();
        return $list;
    }

    public function circle_index($id){
        return get_circle_articles($id);

    }
    
    public function community_index($id){
        return get_community_articles($id);

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
        $title = $data["title"];
        $body = $data["body"];
        $to = $data["to"];

        $user_id = Auth::user()->id;

        $article = new \App\Article;
        $article->title = $title;
        $article->body = $body;
        $article->likes = 0;
        $article->author_id = $user_id;
        $article->type = "normal";
        if(!$article->save()){
            return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        }

        foreach($to as $t){
            $r = new \App\ArticlePost ;
            $r->article_id = $article->id; 
            
            //这里应该再次检查用户权限。。
            if($t["type"]=="community"){
                $r->owner_type = "community";
            }
            if($t["type"]=="circle"){
                $r->owner_type = "circle";
            }

            $r->owner_id = $t["id"];
            $r->save();
        }
  
            return $this->response->array(['status_code'=>666 , "message"=>"success"]);


    }
}
