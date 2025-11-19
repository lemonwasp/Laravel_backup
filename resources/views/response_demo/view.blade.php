<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>뷰 응답 데모</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .demo-links {
            margin-top: 30px;
            text-align: center;
        }
        .demo-links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .demo-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 뷰 응답 데모</h1>
        <p>이것은 Laravel의 <strong>뷰(View) 응답</strong>입니다!</p>
        <p>Blade 템플릿 엔진을 사용하여 HTML을 렌더링하고 있습니다.</p>
        
        <h3>다른 응답 타입들도 테스트해보세요:</h3>
        <div class="demo-links">
            <a href="{{ route('response-demo.string') }}">문자열 응답</a>
            <a href="{{ route('response-demo.json') }}">JSON 응답</a>
            <a href="{{ route('response-demo.download') }}">파일 다운로드</a>
            <a href="{{ route('response-demo.redirect') }}">리디렉션</a>
        </div>
    </div>
</body>
</html>



