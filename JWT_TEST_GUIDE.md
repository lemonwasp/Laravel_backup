# JWT 인증 테스트 가이드

## 사전 준비

1. **Laravel 서버 실행 확인**
   - 서버가 실행 중이어야 합니다 (`php artisan serve` 또는 Sail 사용)

2. **데이터베이스 연결 확인**
   - MySQL/SQLite 데이터베이스가 연결되어 있어야 합니다

## 테스트 방법

### 1. 사용자 생성 (없는 경우)

```bash
php artisan tinker
```

Tinker에서:
```php
$user = App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password123')
]);
```

### 2. 로그인 테스트 (토큰 받기)

```bash
curl -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'
```

**성공 응답 예시:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

### 3. 내 정보 조회 테스트 (토큰 사용)

위에서 받은 `access_token` 값을 사용:

```bash
curl -X POST http://localhost/api/auth/me \
  -H "Authorization: Bearer <여기에_토큰_붙여넣기>" \
  -H "Content-Type: application/json"
```

### 4. 로그아웃 테스트

```bash
curl -X POST http://localhost/api/auth/logout \
  -H "Authorization: Bearer <토큰>" \
  -H "Content-Type: application/json"
```

### 5. 토큰 갱신 테스트

```bash
curl -X POST http://localhost/api/auth/refresh \
  -H "Authorization: Bearer <토큰>" \
  -H "Content-Type: application/json"
```

## 문제 해결

- **"could not find driver" 오류**: PHP에 MySQL/SQLite 확장이 설치되어 있는지 확인
- **HTML 응답이 나오는 경우**: Laravel 서버가 실행 중인지 확인
- **401 Unauthorized**: 이메일/비밀번호가 올바른지 확인

