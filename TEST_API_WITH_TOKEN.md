# API 토큰 테스트 가이드

터미널 출력을 보니 토큰이 성공적으로 생성되었습니다! 이제 이 토큰을 사용해서 API를 테스트해봅시다.

## 생성된 토큰

터미널에서 확인한 토큰:
```
1|34s6LU5efe7D2ZeEt9xBr8Pi474ntPrECmHoFt9Kcb11a599
```

## 테스트 방법

### 방법 1: 테스트 스크립트 사용 (권장)

WSL 터미널에서:

```bash
# 스크립트에 실행 권한 부여
chmod +x test-api-token.sh

# 스크립트 실행 (토큰을 인자로 전달)
./test-api-token.sh "1|34s6LU5efe7D2ZeEt9xBr8Pi474ntPrECmHoFt9Kcb11a599"
```

### 방법 2: 직접 curl 명령어 사용

WSL 터미널에서:

```bash
# 1. 토큰 없이 API 호출 (실패 예상)
curl -X GET http://localhost/api/user \
  -H "Accept: application/json"

# 예상 결과:
# {"message":"Unauthenticated."}

# 2. 토큰과 함께 API 호출 (성공!)
curl -X GET http://localhost/api/user \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|34s6LU5efe7D2ZeEt9xBr8Pi474ntPrECmHoFt9Kcb11a599"

# 예상 결과:
# {
#   "id": 1,
#   "name": "사용자 이름",
#   "email": "사용자@이메일.com",
#   ...
# }
```

### 방법 3: Postman 또는 다른 API 클라이언트 사용

1. **URL**: `http://localhost/api/user`
2. **Method**: `GET`
3. **Headers**:
   - `Accept`: `application/json`
   - `Authorization`: `Bearer 1|34s6LU5efe7D2ZeEt9xBr8Pi474ntPrECmHoFt9Kcb11a599`

## 예상 결과

### 토큰 없이 호출 시:
```json
{
  "message": "Unauthenticated."
}
```

### 토큰과 함께 호출 시:
```json
{
  "id": 1,
  "name": "사용자 이름",
  "email": "user@example.com",
  "email_verified_at": null,
  "created_at": "2025-11-11T00:00:00.000000Z",
  "updated_at": "2025-11-11T00:00:00.000000Z"
}
```

## 문제 해결

### 토큰이 작동하지 않을 때

1. **토큰 확인**: 토큰을 정확히 복사했는지 확인 (앞뒤 공백 없이)
2. **Bearer 키워드**: `Authorization` 헤더에 `Bearer` 키워드가 포함되어 있는지 확인
3. **토큰 형식**: 토큰은 `1|`로 시작하는 긴 문자열입니다
4. **서버 실행 확인**: Laravel 서버가 실행 중인지 확인 (`sail up -d`)

### 새 토큰 발급하기

토큰을 잃어버렸거나 새로 발급하고 싶다면:

```bash
./vendor/bin/sail artisan tinker
```

Tinker에서:
```php
$user = \App\Models\User::find(1);
$token = $user->createToken('my-app-token')->plainTextToken;
echo $token;
exit
```

## 다음 단계

토큰 인증이 성공적으로 작동한다면:

- ✅ API 엔드포인트 보호 완료
- ✅ 모바일 앱이나 다른 클라이언트에서 이 토큰을 사용할 수 있습니다
- ✅ 토큰 기반 인증 시스템 구축 완료!

축하합니다! 🎉

