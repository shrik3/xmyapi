<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $result = \App\Article::all();
        foreach ($result as $a) {
            $a['front_image']=url('images/x.jpg');
            $a['icon_image'] = url('images/unnamed.png');
            $a['likes'] = rand(0,2333);
            $a['comments'] = rand(0,312);

            // 这里可以优化为 select name from communities
            $community = \App\Community::find($a['owner_id']);
            $a['owner_name'] = $community['name'];
        }
        return $result;
    }

    public function show($id)
    {
        $result = \App\Article::find($id);
        // 这里是一个伪实现，模型关系未完成
        if ($result) {
            $result['front_image']=url('images/x.jpg');
            $result['icon_image'] = url('images/unnamed.png');
            $result['likes'] = rand(0,2333);
            $result['comments'] = rand(0,312);

            $community = \App\Community::find($result['owner_id']);
            $result['owner_name'] = $community['name'];
        }

        //str_replace("\\/" , "/" , json_encode($array_name));
        return $result;
    }
}
