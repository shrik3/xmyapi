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
        DB::table('comments')->delete();

        // create 10 communitie info
        for ($i=0; $i < 10; $i++) {
            \App\Community::create([
                'name'   => '社团 '.$i,
                'brief'    => '这里是偷工减料的社团简介=w= '.$i,
            ]);
        }

        // create 1 article and 1 icon for each community
        $communities = \App\Community::all();
        foreach ($communities as $community) {
            \App\Article::create([
                'title'   => 'Title '.$community['id'],
                'body'    => 'Body 测试用文章内容，所有者id为： '.$community['id'],
                'owner_id' => $community['id'],
                'likes' => rand(0,100),
        ]);

            \App\Photo::create([
                'title' => 'icon'.$community['id'],
                'file_name' => 'test.png',
                'type' =>'CommunityIcon',
                'owner_id' => $community['id'],

            ]);
        }

        // create 5 comments for each article

        $articles = \App\Article::all();
        foreach ($articles as $article){
            for($i=1;$i<6;$i++){
                \App\Comment::create([
                    'title'   => 'Comment '.$i,
                    'body'    => 'test comment '.$i.' on article '.$article['id'],
                    'owner_type'    => 'user',
                    'owner_id' => $i,
                    'article_id' => $article['id'],
                    'likes' => rand(0,100),
                ]);
            }
            // create 1 front_photo for each article
            \App\Photo::create([
                'title' => 'front'.$article['id'],
                'file_name' => 'x.jpg',
                'type' => 'Poster',
                'owner_id' => $article['id'],
            ]);
        }
    }
}
