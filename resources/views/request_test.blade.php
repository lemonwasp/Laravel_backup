<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Request Test Form</title>
</head>
<body>
    <h1>Request Test</h1>

    {{-- 유효성 검사 에러 메시지 표시 --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('request.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p>
            <label for="name">이름:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </p>
        <p>
            <label for="email">이메일: </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </p>
        <p>
            <label for="password">비밀번호: </label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <label for="profile_image">프로필 사진: </label>
            <input type="file" name="profile_image" id="profile_image">
        </p>
        <button type="submit">제출</button>
    </form>
</body>
</html>
