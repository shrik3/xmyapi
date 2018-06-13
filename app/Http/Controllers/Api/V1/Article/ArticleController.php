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
        $articles = \DB::table("articles")->join("article_posts","articles.id","=","article_posts.article_id")
                                          ->join("users","users.id","=","articles.author_id")
                                          ->join("photos","photos.owner_id","=","users.id")
                                          ->where("photos.type","=","UserIcon")
                                          ->select("articles.*","article_posts.owner_id","article_posts.owner_type","users.name as author_name","photos.file_name as user_icon")
                                          ->orderBy("created_at","desc")
                                          ->get();
        foreach($articles as $i){
            if($i->owner_type=="community"){
                $i->owner_name=\DB::table("communities")->select("name")
                                                          ->where("id","=",$i->owner_id)
                                                          ->first()->name;
            }
            if($i->owner_type=="circle"){
                $i->owner_name=\DB::table("circles")->select("name")
                                                          ->where("id","=",$i->owner_id)
                                                          ->first()->name;
            }
            $i->user_icon = get_image_path($i->user_icon);


        }
        $list["status_code"] = 666;
        $list["articles"]  = $articles;
        return $list;
    }

    public function circle_index($id){
        if(!\App\Circle::find($id)){
            return $this->response->array(['status_code'=>501 , "message"=>"circle doesn't exist"]);
        }
        $r["articles"] =  get_circle_articles($id);
        $r["status_code"] = 666;
        return $r;
    }
    
    public function community_index($id){
        if(!\App\Community::find($id)){
            return $this->response->array(['status_code'=>501 , "message"=>"community doesn't exist"]);
        }
        $r["articles"]= get_community_articles($id);
        $r["status_code"] = 666;
        return $r;

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

    public function comment(Request $request){
        $content = $request->getContent();
        // 检测是否为 json 数据
        if (is_not_json($content)) {
            // $this->response->errorBadRequest('this is not json , fuck you');
            return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
        }
        // json 数据解码
        $data = json_decode($content, true);
        $body = $data["body"];
        $article_id = $data["article_id"];
        if(!\App\Article::find($article_id)){
            return $this->response->array(['status_code'=>501 , "message"=>"article doesn't exist"]);
        }
        $user_id = Auth::user()->id;
        $comment = new \App\Comment;
        $comment->title = "NA";
        $comment->body = $body;
        $comment->likes = 0;
        $comment->author_id = $user_id;
        $comment->object_type = "article";
        $comment->object_id = $article_id;

        if(!$comment->save()){
            return $this->response->array(['status_code'=>101 , "message"=>"failed to save"]);
        }
        return $this->response->array(['status_code'=>666 , "message"=>"success"]);

    }

    public function show_comments($id){
        $comments = get_article_comments($id);
        $result['status_code']=666;
        $result['comments'] = $comments;
        return $result;
    }
}
