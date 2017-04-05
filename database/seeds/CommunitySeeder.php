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
        DB::table('articles')->delete();

        for ($i=0; $i < 10; $i++) {
            \App\Community::create([
                'name'   => '社团 '.$i,
                'brief'    => '这里是偷工减料的社团简介=w= '.$i,
            ]);
        }

        $communities = \App\Community::all();
        foreach ($communities as $community) {
            \App\Article::create([
                'title'   => 'Title '.$community['id'],
                'body'    => 'Body 测试用文章内容，所有者id为： '.$community['id'],
                'owner_id' => $community['id'],
        ]);

        }
    }
}
