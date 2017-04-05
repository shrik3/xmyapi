<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index(){
        $result = \App\Article::all();
        foreach ($result as $a) {
            $a['front_image']=url('images/x.jpg');
        }
        return $result;
    }

    public function show($id){
        $result = \App\Article::find($id);
        $result['front_image']=url('images/x.jpg');
        return $result;
    }


}
