<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset='utf-8'>
    <title>사용자 정보 - 레이어드 아키텍처</title>
</head>
<body>
    <h1>사용자 정보</h1>
    
    @if($user)
        <p><strong>이름:</strong> {{ $user->name }}</p>
        <p><strong>이메일:</strong> {{ $user->email }}</p>
        <p><strong>가입일:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</p>
        
        <hr>
        <p><a href="/layered/user/home">홈으로</a> | <a href="/layered/user/logout">로그아웃</a></p>
    @else
        <p>사용자를 찾을 수 없습니다.</p>
        <p><a href="/layered/user/home">홈으로</a></p>
    @endif
</body>
</html>




