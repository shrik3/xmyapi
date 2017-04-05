<?php

use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('communities')->delete();

        for ($i=0; $i < 10; $i++) {
            \App\Community::create([
                'name'   => '社团 '.$i,
                'brief'    => '这里是偷工减料的社团简介=w= '.$i,
            ]);
        }

    }
}
