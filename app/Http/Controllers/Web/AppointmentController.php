<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    //
    public function show(){
        $id = [2,3,4];
        return view('apo')->withId($id);
    }
}
