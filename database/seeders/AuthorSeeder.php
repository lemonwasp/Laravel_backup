<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // author 테이블에 데이터 삽입
        DB::table('authors')->insert([
            'name' => '김작가',
            'created_at' => now(),
            'updated_at' => now(), 
        ]);
    }
}
