<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'level_id'=> 1,
                'username'=> 'admin',
                'password'=> Hash::make('12345')
            ],
            [
                'user_id' => 2,
                'level_id'=> 2,
                'username'=> 'dosen',
                'password'=> Hash::make('12345')
            ],
            [
                'user_id' => 3,
                'level_id'=> 3,
                'username'=> 'tendik',
                'password'=> Hash::make('12345')
            ],
            [
                'user_id' => 4,
                'level_id'=> 4,
                'username'=> 'mahasiswa',
                'password'=> Hash::make('12345')
            ]
        ];
        DB::table('m_user')->insert($data);
    }
}

