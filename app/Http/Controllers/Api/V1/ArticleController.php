<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
include('toolbox.php');

class ArticleController extends Controller
{
    //
    use Helpers;
    public function index()
    {
        $result = \App\Article::all();
        foreach ($result as $a) {

            $a['front_image']=get_article_image_path($a['id']);
            $a['comments'] = \App\Comment::where('article_id',1)->count();
            $community = \App\Community::select('name')->where('id',$a['owner_id'])->first();
            $a['owner_name'] = $community['name'];
            // low efficency  : get community icon ...
            $a['icon'] = get_community_icon_path($a['owner_id']);

        }
        return $result;
    }


    public function show($id)
    {
        $result = \App\Article::find($id);
        if ($result) {

            $result['front_image'] = get_article_image_path($id);
            $result['comments'] =  get_comments($id)->count();
            $community = \App\Community::select('name')->where('id',$result['owner_id'])->first();
            $result['owner_name'] = $community['name'];
            $result['icon'] = get_community_icon_path($result['owner_id']);
        }

        //str_replace("\\/" , "/" , json_encode($array_name));
        return $result;
    }
}
