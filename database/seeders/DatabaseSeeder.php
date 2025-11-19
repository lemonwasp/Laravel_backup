<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;
use App\Models\BookDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // 10명의 사용자를 생성
    //     User::factory(10)->create()
    //         ->each(function ($user) {
    //             // 각 사용자는 1~3개의 게시글을 작성
    //             Article::factory(rand(1, 3))->create(['user_id' => $user->id])
    //                 ->each(function ($article) {
    //                     // 각 게시글에는 0~5개의 댓글이 달림
    //                     Comment::factory(rand(0, 5))->create(['article_id' => $article->id]);
    //                 });
    //         });
    // }
    public function run(): void
    {
        // $this->call([
        //     AuthorSeeder::class,
        //     PublisherSeeder::class,
        // ]);
        // 1. 저자(Author) 10명 생성
        Author::factory(10)->create();
        
        // 2. 출판사(Publisher) 5곳 생성
        Publisher::factory(10)->create();

        // 3. 책(Book) 30권 생성 (위에서 만든 저자와 출판사를 랜덤으로 사용)
        // each()메소드를 사용하여 생성된 각 책에 대한 상세 정보(BookDetail)도 함께 생성
        Book::factory(30)->create()->each(function ($book) {
            BookDetail::factory()->create(['book_id' => $book->id]);
        });
    }
}
