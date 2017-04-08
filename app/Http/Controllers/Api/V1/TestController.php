<?php


namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    //TestController
    public function show($id){
        return 'testing on request id '.$id;
    }

}
