<?php


namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RequestTest;

class TestController extends Controller
{
    use RequestTest;
    //TestController
    public function show(Request $request){
        $this->check_request($request,['test']);
        return ('fuck you , done');
    }

}
