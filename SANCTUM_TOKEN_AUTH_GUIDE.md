# 라라벨 API 토큰 인증 완벽 정복 가이드 (feat. Sanctum)

이 가이드는 Laravel Sanctum을 사용한 API 토큰 인증을 설정하는 단계별 가이드입니다.

## 시작하기 전에: 세션 vs 토큰

### 웹사이트 로그인 (세션 방식)
- **비유**: 놀이공원 프리패스
- 로그인하면 손목밴드(세션/쿠키)를 받아서 계속 놀이기구를 탈 수 있음
- 웹 브라우저에 최적화된 방식

### API 로그인 (토큰 방식)
- **비유**: 드라이브스루 주문
- 스마트폰 앱이나 다른 프로그램이 서버에서 데이터를 가져올 때, 미리 정해진 **'비밀 암호(토큰)'**를 제시해야 함
- 예: "감자튀김 주문할게요! (비밀 암호: #$@*!)"
- 프로그램 간 통신에 매우 유용한 방식

**Sanctum**은 이러한 '비밀 암호(토큰)'를 안전하게 만들고, 관리하고, 확인하는 모든 과정을 처리해주는 멋진 도구입니다!

## 현재 프로젝트 상태

✅ Laravel Sanctum이 이미 설치되어 있습니다 (`composer.json` 확인)
✅ Sanctum 설정 파일이 이미 존재합니다 (`config/sanctum.php`)
✅ `personal_access_tokens` 테이블 마이그레이션이 이미 있습니다
✅ API 라우트에 `auth:sanctum` 미들웨어가 적용되어 있습니다
✅ User 모델에 `HasApiTokens` 트레이트가 추가되었습니다

## 실습 단계

### 1. Sanctum 패키지 설치 확인

Sanctum이 이미 설치되어 있는지 확인:

```bash
./vendor/bin/sail composer show laravel/sanctum
```

만약 설치되어 있지 않다면:

```bash
./vendor/bin/sail composer require laravel/sanctum
```

### 2. Sanctum 설정 파일 확인

Sanctum 설정 파일이 이미 있는지 확인:

```bash
ls config/sanctum.php
```

만약 없다면 설정 파일을 내보내기:

```bash
./vendor/bin/sail artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 3. 데이터베이스 테이블 만들기

Sanctum이 발급한 토큰을 저장할 데이터베이스 테이블을 생성합니다:

```bash
./vendor/bin/sail artisan migrate
```

이 명령어를 실행하면 `personal_access_tokens`라는 테이블이 생성됩니다.

### 4. User 모델에 능력 부여하기

User 모델에 API 토큰을 다룰 수 있는 능력을 부여해야 합니다.

**파일**: `app/Models/User.php`

다음과 같이 수정되었습니다:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. 이 줄을 추가

class User extends Authenticatable
{
    // 2. HasApiTokens를 추가
    use HasApiTokens, HasFactory, Notifiable;
    
    // ... 나머지 코드 ...
}
```

**핵심 포인트:**
- `use Laravel\Sanctum\HasApiTokens;` - Sanctum의 HasApiTokens 클래스를 import
- `use HasApiTokens, HasFactory, Notifiable;` - User 클래스에 HasApiTokens 트레이트 추가

### 5. API 전용 주소(Route) 만들기

API 관련 주소는 `routes/api.php` 파일에서 관리합니다.

**파일**: `routes/api.php`

이미 다음과 같은 코드가 있습니다:

```php
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
```

**핵심 포인트:**
- `middleware('auth:sanctum')` - 이 부분이 핵심입니다!
- `auth:sanctum` 미들웨어는 이 주소의 '경비원' 역할을 합니다
- Sanctum이 발급한 유효한 토큰이 있는 요청만 통과시킵니다
- 토큰이 없거나 유효하지 않으면 "Unauthenticated" 메시지를 반환합니다

### 6. 나만의 비밀 암호, 토큰 발급받기

API를 테스트하려면 토큰이 필요합니다. `tinker`라는 강력한 라라벨 도구(코드 실험실 같은 것)를 사용해서 사용자에게 토큰을 발급할 수 있습니다.

#### 6.1. Tinker 접속하기

터미널에서 다음 명령어 실행:

```bash
./vendor/bin/sail artisan tinker
```

`>>>` 프롬프트가 나타나면 명령어를 하나씩 입력합니다.

#### 6.2. 사용자 찾기

이전 실습에서 회원가입한 첫 번째 사용자(ID가 1인 사용자)를 찾습니다:

```php
$user = \App\Models\User::find(1);
```

#### 6.3. 토큰 생성하기

찾은 사용자에게 '내 앱을 위한 토큰'이라는 이름으로 토큰을 생성합니다:

```php
$token = $user->createToken('my-app-token')->plainTextToken;
```

- `createToken()` 함수가 토큰을 생성합니다
- `plainTextToken`은 실제 비밀 문자열을 추출합니다

#### 6.4. 토큰 확인 및 복사

생성된 토큰을 확인합니다:

```php
echo $token;
```

**⚠️ 중요**: 반드시 전체를 복사해두세요! 이 토큰은 지금 딱 한 번만 보여주기 때문에, 창을 닫으면 다시 볼 수 없어요.

출력 예시:
```
1|XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXxx
```

이 긴 문자열이 바로 API 접근을 위한 '비밀 키'입니다!

#### 6.5. Tinker 나가기

```php
exit
```

또는 `Ctrl+C`를 눌러도 됩니다.

### 7. 최종 테스트: 토큰으로 API 호출하기

이제 `curl` 명령어를 사용해서 API를 테스트해봅시다!

#### 테스트 1: 토큰 없이 API 호출하기 (실패 예상)

경비원(`auth:sanctum`)이 제대로 작동하는지 확인하는 테스트입니다:

```bash
curl -X GET http://localhost/api/user -H "Accept: application/json"
```

**예상 결과:**
```json
{"message": "Unauthenticated."}
```

토큰이 없으므로 요청이 차단되었습니다! ✅

#### 테스트 2: 토큰과 함께 API 호출하기 (성공!)

이제 복사한 '비밀 키(토큰)'를 사용해봅시다. `Authorization` 헤더에 `Bearer` 키워드와 함께 토큰을 넣어주면 됩니다:

```bash
# <여러분이_복사한_토큰> 부분을 실제 토큰으로 꼭 바꿔주세요!
curl -X GET http://localhost/api/user \
  -H "Accept: application/json" \
  -H "Authorization: Bearer <여러분이_복사한_토큰>"
```

**예상 결과:**
성공하면 등록한 사용자 정보가 아래처럼 아름답게 JSON 형식으로 표시됩니다!

```json
{
  "id": 1,
  "name": "Your Name",
  "email": "your@email.com",
  "email_verified_at": null,
  "created_at": "...",
  "updated_at": "..."
}
```

🎉 **성공!** 토큰 인증이 완벽하게 작동합니다!

## 정리

정말 대단해요! 여러분은 이제 Laravel Sanctum을 이용해서 안전한 API 인증 시스템을 구축하는 방법을 배우셨어요.

### 배운 내용 요약:

- ✅ API 인증에는 세션 대신 토큰을 사용한다는 것을 알게 됐어요
- ✅ Sanctum을 설치하고, User 모델에 `HasApiTokens` 능력을 부여했어요
- ✅ `routes/api.php`에 `auth:sanctum` 경비원을 배치해서 API를 보호했어요
- ✅ `tinker`를 이용해 사용자에게 토큰을 발급하고, 그 토큰으로 API를 호출하는 데 성공했어요!

### Sanctum의 강력함

복잡한 과정들(직접 Provider 만들기, 인터페이스 구현하기 등)을 Sanctum이 얼마나 간단하게 처리해주는지 느낄 수 있었을 거예요. 이것이 바로 최신 기술을 배우는 즐거움이랍니다!

## 추가 학습

이제 기본적인 토큰 인증이 완료되었습니다! 추가로 학습할 수 있는 내용:

- 토큰 만료 시간 설정
- 토큰 권한(abilities) 설정
- 토큰 삭제 및 관리
- SPA(Single Page Application) 인증
- 모바일 앱과의 통신
- API Rate Limiting

## 문제 해결

### 토큰이 작동하지 않을 때
- 토큰을 정확히 복사했는지 확인 (앞뒤 공백 없이)
- `Bearer` 키워드와 토큰 사이에 공백이 있는지 확인
- 데이터베이스에 `personal_access_tokens` 테이블이 생성되었는지 확인

### Tinker에서 사용자를 찾을 수 없을 때
- 먼저 사용자가 등록되어 있는지 확인: `\App\Models\User::all()`
- 또는 새 사용자를 생성: `\App\Models\User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => bcrypt('password')])`

### API가 404 에러를 반환할 때
- `routes/api.php` 파일에 라우트가 올바르게 정의되어 있는지 확인
- `php artisan route:list` 명령어로 라우트 목록 확인

