<?php

use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = \App\User::all();
        $comms = \App\Community::all();

        foreach ($users as $user){
            foreach($comms as $com){
                if(rand(1,6)<4) {
                    $membership = new \App\Membership();
                    $membership->member_id = $user['id'];
                    $membership->community_id = $com['id'];
                    $membership->role = rand(0,4);
                    $membership->save();
                }
            }
        }
    }
}
