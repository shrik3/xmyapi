<?php


namespace App\Http\Controllers\Api\V1\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    //TestController
    public function test($id){
        return 'testing on request id  '.$id.' this page is under protection';
    }

}
