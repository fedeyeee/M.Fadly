<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Administrator',
                'password' => bcrypt('123456'),
                'level' =>1,
                'email' => 'admin@gmail.com'
            ],
            [
                'name' => 'petugas',
                'password' => bcrypt('123456'),
                'level' =>2,
                'email' => 'petugas@gmail.com'
            ],
        ];
            foreach($user as $key => $value){
                User::create($value);
            }
    }
}