<?php

class ArticleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('articles')->delete();

        User::create(array(
        	'title' => 'This is my first article',
            'content' => "Heres some content for this article..."
        ));
    }

}