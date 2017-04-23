<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Traits\CommunityTools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use \App\Traits\AuthTools;
use \App\Traits\RequestTest;
use \App\Traits\MembershipTools;
use Dingo\Api\Routing\Helpers;

class MembershipController extends Controller {
    //
    use AuthTools;
    use RequestTest;
    use CommunityTools;
    use MembershipTools;

    public function index() {
        $ships = \App\Membership::all();
        foreach ($ships as $ship) {
            $ship['community_name'] = \App\Community::find($ship['community_id'])['name'];
            $ship['member_name'] = \App\User::find($ship['member_id'])['name'];
        }
        return $ships;
    }

    public function join(Request $request) {
        // for new member request
        $data = $this->check_request($request, ['community_id']);
        $community = \App\Community::find($data['community_id']);
        if (!$community) {
            $this->response()->errorBadRequest('community not found');
            return null;
        }

        $user = $this->getAuthenticatedUser();
        $r = \App\Membership::where(['community_id' => $community['id'],
            'member_id' => $user['id']])->count();

        if ($r > 0) {
            $this->response()->errorBadRequest('Cannot join twice');
            return null;
        }

        $membership = new \App\Membership();
        $membership->member_id = $user['id'];
        $membership->community_id = $community['id'];
        $membership->role = 0;
        $membership->save();
        return json_encode(['status' => 'done', 'code' => 200]);

    }

    public function newbie_list() {
        // this method returns a list of join request.
        // note: only available for community members who
        // have an at least 'role>=3' privilege
        $request_user = $this->getAuthenticatedUser();
        // test
        return 'test';
    }

    public function my_groups() {
        $user = $this->getAuthenticatedUser();
        $groups = \App\Membership::select('community_id','role')->where(['member_id'=>$user['id']])->get()->toArray();
        $result = [];
        foreach($groups as $group){
            $com = \App\Community::find($group['community_id']);
            $com['icon'] = $this->ge_icon_path($group['community_id']);
            $com['role'] = $this->get_role($group['role']);
            array_push($result,$com);
        }
        return $result;
    }

}
