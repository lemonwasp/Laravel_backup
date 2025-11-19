<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset='utf-8'>
    <title>로그인 - 레이어드 아키텍처</title>
</head>
<body>
    <h1>로그인 (레이어드 아키텍처)</h1>
    
    @isset($errors)
        <p style="color:red">{{ $errors->first('message') }}</p>
    @endisset
    
    <form name="loginform" action="/layered/user/login" method="post">
        @csrf
        <dl>
            <dt>메일주소:</dt>
            <dd><input type="text" name="email" size="30" value="{{ old('email') }}"></dd>
        </dl>
        <dl>
            <dt>비밀번호: </dt>
            <dd><input type="password" name="password" size="30"></dd>
        </dl>
        <button type='submit' name='action' value='send'>로그인</button>
    </form>
    
    <hr>
    <p><a href="/layered/user/home">홈으로</a> | <a href="/layered/user/register">회원가입</a></p>
</body>
</html>




