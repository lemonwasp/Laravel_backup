<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset='utf-8'>
    <title>홈 - 레이어드 아키텍처</title>
</head>
<body>
    <h1>레이어드 아키텍처 홈</h1>
    <p>안녕하세요!</p>
    
    @if (Auth::check())
        <p>{{ \Auth::user()->name }}님</p>
        <p><a href="/layered/user/{{ \Auth::user()->id }}">내 정보 보기</a> | <a href="/layered/user/logout">로그아웃</a></p>
    @else
        <p>게스트님</p>
        <p><a href="/layered/user/login">로그인</a> | <a href="/layered/user/register">회원가입</a></p>
    @endif
    
    <hr>
    <h2>아키텍처 정보</h2>
    <p><strong>Controller → Service → Repository → DB</strong></p>
    <ul>
        <li><strong>Controller:</strong> HTTP 요청/응답만 처리</li>
        <li><strong>Service:</strong> 비즈니스 로직에만 집중 (데이터를 '어떻게' 가져오는지는 모름)</li>
        <li><strong>Repository:</strong> 데이터 영속성에만 집중 (Eloquent, Query Builder 등)</li>
    </ul>
</body>
</html>




