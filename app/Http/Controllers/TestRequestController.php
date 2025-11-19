<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestRequestController extends Controller
{
    // GET /request-test
    public function create()
    {
        // resources/views/request_test.blade.php 뷰를 반환
        return view('request_test');
    }

    // POST /request-test
    public function store(Request $request)
    {
        // JSON 요청인지 확인
        $isJsonRequest = $request->isJson() || $request->wantsJson() || $request->path() === 'api/request-test';
        
        // 1. 단일 값 가져오기
        $name = $request->input('name'); // 'name' 키를 통해 요청으로부터 값을 얻음
        $email = $request->input('email', 'default@example.com'); // 'email' 키가 없으면 'default@example.com'을 기본값으로 반환

        // 2. 모든 입력값 가져오기 (배열)
        $allData = $request->all(); // CSRF 토큰을 포함한 모든 입력 데이터를 배열로 가져옴

        // 3. 일부 입력값만 가져오기 (배열)
        $onlyNameAndEmail = $request->only(['name', 'email']); // 'name'과 'email' 필드만 포함된 배열을 가져옴

        // 4. 특정 입력값을 제외하고 가져오기 (배열)
        $exceptPassword = $request->except('password'); // 'password' 필드를 제외한 모든 입력 데이터를 가져옴

        // 5. 요청에 특정 값이 있는지 확인
        if ($request->has('name')) {
            // 'name' 필드가 요청에 존재하고 비어있지 않은지 확인
        }

        // 6. 업로드된 파일 처리
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $file = $request->file('profile_image');
            $path = $file->store('uploads/profiles'); // 파일을 'uploads/profiles' 디렉토리에 저장하고, Laravel이 자동으로 생성한 파일명을 반환
            $originalName = $file->getClientOriginalName(); // 원본 파일명을 가져옴
        } else {
            $path = '파일 없음';
        }

        // 7. 기타 요청 정보
        $requestPath = $request->path(); // URI 경로를 가져옴 (예: 'request-test')
        $requestUrl = $request->url(); // 쿼리 문자열을 제외한 전체 URL을 가져옴
        $requestMethod = $request->method(); // 요청 메소드를 가져옴 (예: 'POST')
        $userAgent = $request->header('User-Agent'); // 'User-Agent' 헤더 값을 가져옴

        $responseData = [
            'isJsonRequest' => $isJsonRequest,
            'name' => $name,
            'email' => $email,
            'allData' => $allData,
            'onlyNameAndEmail' => $onlyNameAndEmail,
            'exceptPassword' => $exceptPassword,
            'filePath' => $path,
            'requestPath' => $requestPath,
            'requestUrl' => $requestUrl,
            'requestMethod' => $requestMethod,
            'userAgent' => $userAgent,
        ];

        // JSON 요청이면 JSON 응답, 아니면 dd()로 출력
        if ($isJsonRequest) {
            return response()->json($responseData);
        }

        // dd() 헬퍼 함수는 변수 내용을 출력하고 스크립트 실행을 중단시켜 디버깅에 유용합니다.
        dd($responseData);
    }
}
