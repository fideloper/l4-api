<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'username' => 'your_user',
        	'password' => Hash::make('your_password')
        ));
    }

}