<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 환영</title>
</head>
<body>
    <h1>환영합니다, {{ $user->name }}님!</h1>
    
    <p>저희 서비스에 가입해주셔서 감사합니다.</p>
    
    <h2>가입 정보</h2>
    <ul>
        <li><strong>이름</strong>: {{ $user->name }}</li>
        <li><strong>이메일</strong>: {{ $user->email }}</li>
        <li><strong>가입일</strong>: {{ $user->created_at->format('Y-m-d H:i:s') }}</li>
    </ul>
    
    <p>언제든지 문의사항이 있으시면 연락주세요.</p>
    
    <p>감사합니다.</p>
    
    <p>{{ config('app.name') }}</p>
</body>
</html>
