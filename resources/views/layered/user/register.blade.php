<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset='utf-8'>
    <title>사용자 등록 - 레이어드 아키텍처</title>
</head>
<body>
    <h1>사용자 등록 (레이어드 아키텍처)</h1>
    
    <form name="registform" action="/layered/user/register" method="post" id="registform">
        @csrf
        <dl>
            <dt>이름: </dt>
            <dd>
                <input type="text" name="name" size="30" value="{{ old('name') }}">
                <span style="color: red;">{{ $errors->first('name') }}</span>
            </dd>
        </dl>
        <dl>
            <dt>메일주소:</dt>
            <dd>
                <input type="text" name="email" size="30" value="{{ old('email') }}">
                <span style="color: red;">{{ $errors->first('email') }}</span>
            </dd>
        </dl>
        <dl>
            <dt>비밀번호: </dt>
            <dd>
                <input type="password" name="password" size="30">
                <span style="color: red;">{{ $errors->first('password') }}</span>
            </dd>
        </dl>
        <dl>
            <dt>비밀번호(확인): </dt>
            <dd>
                <input type="password" name="password_confirmation" size="30">
                <span style="color: red;">{{ $errors->first('password_confirmation') }}</span>
            </dd>
        </dl>
        <button type='submit' name='action' value='send'>보내기</button>
    </form>
    
    <hr>
    <p><a href="/layered/user/home">홈으로</a></p>
</body>
</html>




