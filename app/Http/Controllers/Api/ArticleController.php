<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Resources\ArticleResource; // ArticleResource 임포트
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // ... 다른 메소드들

    /**
     * 지정된 리소스를 표시합니다.
     */
    public function show(Article $article)
    {
        // 관계(user, comments)를 미리 로드하여 N+1 문제 방지
        $article->load('user', 'comments.user');
        
        // ArticleResource를 사용하여 응답을 반환
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
