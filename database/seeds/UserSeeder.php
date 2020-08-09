<?php

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 10, 'prefix' =>date('ym')]),
            'api_token' => 'WZMToE3sQkBwszfOrs6WF1hBVrp6zUq45bN3P4yrvqxm4so4uIaAqxfK7bSXR9FefLTMTjRu4pXXwCY2',
            'name' => 'Damar Permadany',
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => 'damarp2017@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);



        \App\User::create([
            'id' => IdGenerator::generate(['table' => 'users', 'length' => 10, 'prefix' =>date('ym')]),
            'api_token' => 'sDgAIGFhOVNVqxlnYRmjKmEohLXDQYwqbrmvKIfhRcVUmHbT474eQWxiTOxbNxwVFH1TqfoH15ZuQyOK',
            'name' => 'Prieyuda Akadita Sustono',
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => 'akaditasustono@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
    }
}
