<?php

class ArticleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('articles')->delete();

        Article::create(array(
        	'user_id' => 1,
        	'title' => 'This is my first article',
            'content' => "Heres some content for this article..."
        ));
    }

}