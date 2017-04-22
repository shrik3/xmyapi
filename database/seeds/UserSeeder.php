<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new \App\User();
            $user->name = 'testUser' . $i;
            $user->password = bcrypt('password' . $i);
            $user->email = 'test' . $i . 'test.com';
            $user->save();
        }


    }
}
