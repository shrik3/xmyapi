<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use JWTAuth;

// 这是一些自定义的工具
require_once('toolbox.php');

class UserController extends Controller {
    //
    use Helpers;

    public function register(Request $request) {
        $content = $request->getContent();
        // 检测是否为 json 数据
        if (is_not_json($content)) {
            // $this->response->errorBadRequest('this is not json , fuck you');
            return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
        }

        // json 数据解码
        $data = json_decode($content, true);

        // 检查完整性
        if (!check_item(["email", "name", "password","nickname"], $data)) {
            // $this->response->errorBadRequest('incomplete data set, fuck you');
            return $this->response->array(['status_code'=>405 , "message"=>"bad request , imcomplete json"]);
        }

        // 检查用户是否已存在
        if (\App\User::where('name', $data['name'])->count() > 0) {
            // $this->response->errorBadRequest('user name is already taken');
            return $this->response->array(['status_code'=>407 , "message"=>"username already taken"]);
        }

        // 检查邮箱是否可用
        if (\App\User::where('email', $data['email'])->count() > 0) {
            // $this->response->errorBadRequest('email address is already taken');
            return $this->response->array(['status_code'=>408 , "message"=>"mail address already taken"]);
        }

        $user = new \App\User();
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->email = $data['email'];
        $user->nickname = $data['nickname'];
        $user->save();


        $success = array("message" => "done", "status_code" => "666");
        return $success;

    }


    // AUTH CONTROL
    public function auth(Request $request) {
        $content = $request->getContent();
        // 检测是否为 json 数据
        if (is_not_json($content)) {
            // $this->response->errorBadRequest('this is not json , fuck you');
            return $this->response->array(['status_code'=>406 , "message"=>"this is not json"]);
        }

        // json 数据解码
        $data = json_decode($content, true);

        // 检查完整性
        if (!check_item(["name", "password"], $data)) {
            // $this->response->errorBadRequest('incomplete data set, fuck you');
            return $this->response->array(['status_code'=>405 , "message"=>"bad request , imcomplete json"]);
        }

        $user = \App\User::where('name', $data['name']);
        if (!$user->count()) {
            // $this->response->errorBadRequest('user does not exist !');
            return $this->response->array(['status_code'=>401 , "message"=>"user does not exist!"]);
        }

        $credentials = ['password' => $data['password'], 'name' => $data['name']];

        try {
            if (!$access_token = JWTAuth::attempt($credentials)) {
                // $this->response->errorUnauthorized('wrong username or password!');
                return $this->response->array(['status_code'=>402 , "message"=>"wrong password"]);
            }
            return $this->response->array(['access_token' => $access_token,"status_code"=>666]);
        } catch (JWTException $e) {
            // $this->response->errorInternal('Unable to generate token');
            return $this->response->array(['status_code'=>403 , "message"=>"internal error"]);
        }


    }
}
