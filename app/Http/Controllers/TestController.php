<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{

    //TestController
    public function show($id){
        return 'testing on request id '.$id;
    }

}
