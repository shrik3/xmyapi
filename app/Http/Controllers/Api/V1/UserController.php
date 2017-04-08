<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

// 这是一些自定义的工具
require_once('toolbox.php');

class UserController extends Controller
{
    //
    use Helpers;

    // 检测是否为 json 数据
    public function register(Request $request){
        $content =  $request->getContent();
        if (is_not_json($content)){
            $this->response->errorBadRequest('this is not json , fuck you');
        }

    // json 数据解码
    $data = json_decode($content,true);

    // 检查完整性
    if (!check_item(["email","name","password"],$data)){
        $this->response->errorBadRequest('incomplete data set, fuck you');
    }

    // 检查用户是否已存在
    if (\App\User::where('name', $data['name'])->count() > 0) {
            $this->response->errorBadRequest('user name is already taken');
    }

    // 检查邮箱是否可用
    if (\App\User::where('email', $data['email'])->count() > 0) {
            $this->response->errorBadRequest('email address is already taken');
    }

    $user = new \App\User();
    $user->name = $data['name'];
    $user->password = bcrypt($data['password']);
    $user->email = $data['email'];
    $user->save();

    $success = array("message"=>"done","status_code"=>"200");
    return $success;
    }

}
