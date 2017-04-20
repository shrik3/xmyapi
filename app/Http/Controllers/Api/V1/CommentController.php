<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //
    public function show($article_id){
        $results = get_comments($article_id)->get();
        return $results;

    }
}
