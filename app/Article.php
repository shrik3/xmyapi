<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    //
    public function owner(){

        return $this->hasOne('App\Community','id','owner_id');
    }

}
