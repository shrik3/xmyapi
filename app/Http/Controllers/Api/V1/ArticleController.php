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
        }
        return $result;
    }

    public function show($id)
    {
        $result = \App\Article::find($id);
        if ($result) {
            $result['front_image']=url('images/x.jpg');
        }

        //str_replace("\\/" , "/" , json_encode($array_name));
        $test1 = str_replace("\\/", "/", json_encode($result));
        $test2 = json_encode($result);
        return $test1;
    }
}
