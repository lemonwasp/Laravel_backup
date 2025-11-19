<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ResponseDemoController extends Controller
{
    /**
     * 문자열 응답을 반환합니다.
     */
    public function string()
    {
        // 단순 문자열 반환
        // return 'Hello, World!';
        
        // response() 헬퍼를 사용하여 헤더와 상태 코드 지정
        return response('Hello, World!', Response::HTTP_OK, [
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * 뷰 응답을 반환합니다.
     */
    public function view()
    {
        // view() 헬퍼는 자동으로 뷰를 렌더링한 응답을 생성함
        // 'welcome' 뷰를 재사용
        return view('welcome', ['message' => '뷰에서 전달된 메시지입니다.']);
    }

    /**
     * JSON 응답을 반환합니다.
     */
    public function json()
    {
        $data = [
            'id' => 1,
            'name' => 'Gemini User',
            'email' => 'gemini@example.com',
        ];
        // 배열을 직접 반환해도 라라벨이 JSON으로 변환해줌
        // return $data;

        // 명시적으로 json() 메소드를 사용하여 응답 생성
        return response()->json($data);
    }

    /**
     * 파일 다운로드 응답을 반환합니다.
     */
    public function download()
    {
        // storage_path()는 storage 디렉토리의 절대 경로를 반환함
        $filePath = storage_path('app/test.txt');
        $fileName = 'user-guide.txt'; // 다운로드될 때 사용자에게 보여질 파일명
        
        // 파일이 존재하지 않을 경우 404 에러 반환
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        // download() 헬퍼를 사용하여 파일 다운로드 응답 생성
        return response()->download($filePath, $fileName);
    }

    /**
     * 리디렉션 응답을 생성합니다.
     */
    public function redirect()
    {
        return redirect()->route('response-demo.redirect-target')->with('status', '성공적으로 리디렉션되었습니다!');
    }

    /**
     * 리디렉션 도착지 메소드입니다.
     */
    public function redirectTarget(Request $request)
    {
        $status = session('status');
        return "리디렉션 도착! 메시지: " . ($status ?? '메시지 없음');
    }
}