<?php


namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthTools;

class TestController extends Controller {
    use AuthTools;
    public function me(){
        $user = $this->getAuthenticatedUser();
        return $user;
    }

}
