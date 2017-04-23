<?php
namespace App\Traits;

trait MembershipTools {

    public function get_role($role) {
        $dict = [
            -2 => 'black list',
            -1 => 'declined',
            0 => 'waiting for approval',
            1 => 'normal member',
            2 => 'senior member',
            3 => 'admin',
            4 => 'chair_man'
        ];
        return $dict[$role];
    }
}