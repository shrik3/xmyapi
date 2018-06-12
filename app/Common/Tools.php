<?php


function is_not_json($str) {
    return is_null(json_decode($str));
}

function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function check_item($items, $array) {

    foreach ($items as $item) {
        if (!array_key_exists($item, $array)) {
            return false;
        }
    }

    return true;
}


function get_community_icon_path($community_id) {
    $icon = \App\Photo::select('file_name')
        ->where([
            'owner_id' => $community_id,
            'type' => 'CommunityIcon'
        ])
        ->first();
    $url = url('images/' . $icon['file_name']);
    return $url;
}

function get_circle_icon_path($circle_id) {
    $icon = \App\Photo::select('file_name')
        ->where([
            'owner_id' => $circle_id,
            'type' => 'CircleIcon'
        ])
        ->first();
    $url = url('images/' . $icon['file_name']);
    return $url;
}

function get_community_id($name) {
    $id = \App\Community::select('id')->where(['name' => $name])->first()["id"];
    return $id;

}


function get_comments($article_id) {
    $result = \App\Comment::where('article_id', $article_id);
    return $result;
}

function get_article_image_path($article_id) {
    $front_image = \App\Photo::select('file_name')
        ->where([
            'owner_id' => $article_id,
            'type' => 'Poster'
        ])
        ->first();
    $url = url('images/' . $front_image['file_name']);
    return $url;

}

function get_member_role($role_code){
    $list = [
        0 => "creator" ,
        1 => "manager" ,
        2 => "normal member" ,
        3 => "tobe member" ,
        4 => "black list"
    ];
    return $list[$role_code]; 
}

function get_user_role($user_id,$com_id){
    $mem = \App\Membership::where(['member_id'=>$user_id,"community_id"=>$com_id])->first();
    if(!$mem) {
        return 99;
    }
    return $mem['role'];
}

function get_circle_user_role($user_id,$cir_id){
    $mem = \App\CircleMembership::where(['member_id'=>$user_id,'circle_id'=>$cir_id])->first();
    if(!$mem) {
        return 99;
    }
    return $mem['role'];
}