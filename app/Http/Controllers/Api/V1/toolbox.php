<?php

function is_not_json($str){
    return is_null(json_decode($str));
}

function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function check_item($items,$array){

    foreach($items as $item){
        if (!array_key_exists($item,$array)){
            return false;
        }
    }

    return true;
}

$success = array("message"=>"done","status_code"=>"200");
