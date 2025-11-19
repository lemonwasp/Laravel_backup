# 데이터베이스 확인 가이드

## 방법 1: Tinker로 간단하게 확인 (가장 쉬움!)

WSL 터미널에서:

```bash
./vendor/bin/sail artisan tinker
```

Tinker에서 다음 명령어들을 하나씩 입력:

### 1. Users 테이블 확인
```php
User::all(['id', 'name', 'email']);
```

### 2. Personal Access Tokens 확인
```php
\Laravel\Sanctum\PersonalAccessToken::all();
```

### 3. 특정 사용자의 토큰 확인
```php
$user = User::find(1);
$user->tokens;
```

### 4. Tinker 나가기
```php
exit
```

## 방법 2: 스크립트 사용

```bash
chmod +x check-database.sh
./check-database.sh
```

## 방법 3: MySQL 직접 접속

```bash
./vendor/bin/sail mysql
```

MySQL에서:
```sql
-- 데이터베이스 선택
USE laravel;

-- Users 테이블 확인
SELECT id, name, email FROM users;

-- Personal Access Tokens 테이블 확인
SELECT id, tokenable_id, name, created_at FROM personal_access_tokens;

-- 나가기
exit;
```

## Personal Access Tokens 테이블 구조

- `id`: 토큰 ID
- `tokenable_id`: 사용자 ID (users 테이블과 연결)
- `tokenable_type`: 모델 타입 (보통 "App\Models\User")
- `name`: 토큰 이름 (예: "my-app-token")
- `token`: 해시된 토큰 (처음 4자만 저장됨)
- `abilities`: 토큰 권한
- `last_used_at`: 마지막 사용 시간
- `expires_at`: 만료 시간
- `created_at`, `updated_at`: 생성/수정 시간

## 팁

- 토큰은 보안을 위해 해시되어 저장됩니다 (전체 토큰이 아닌 일부만)
- `token` 컬럼에는 토큰의 처음 4자만 저장됩니다
- 전체 토큰은 발급 시 한 번만 보여주고, 이후에는 볼 수 없습니다

