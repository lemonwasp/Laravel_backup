<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리디렉션 도착지</title>
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
            color: #28a745;
            text-align: center;
        }
        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
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
        <h1>✅ 리디렉션 성공!</h1>
        
        <div class="success-message">
            <strong>축하합니다!</strong> 리디렉션 응답이 성공적으로 작동했습니다.
        </div>
        
        <p>이 페이지는 <code>/response-demo/redirect</code>에서 리디렉션되어 도착한 페이지입니다.</p>
        
        <h3>다른 응답 타입들도 테스트해보세요:</h3>
        <div class="demo-links">
            <a href="{{ route('response-demo.string') }}">문자열 응답</a>
            <a href="{{ route('response-demo.view') }}">뷰 응답</a>
            <a href="{{ route('response-demo.json') }}">JSON 응답</a>
            <a href="{{ route('response-demo.download') }}">파일 다운로드</a>
            <a href="{{ route('response-demo.redirect') }}">다시 리디렉션</a>
        </div>
    </div>
</body>
</html>



