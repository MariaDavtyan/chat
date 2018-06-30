<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([

            [
                'name' => 'Test',
                'email' => 'guest@domain.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test0',
                'email' => 'test0@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test1',
                'email' => 'test1@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test2',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test3',
                'email' => 'test3@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test4',
                'email' => 'test4@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test5',
                'email' => 'test5@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test6',
                'email' => 'test6@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test7',
                'email' => 'test7@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Test8',
                'email' => 'test8@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
            ],

        ]);
    }
}
