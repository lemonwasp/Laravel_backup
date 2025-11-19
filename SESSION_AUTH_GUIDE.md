# 라라벨 세션 기반 인증 완벽 정복 가이드

이 가이드는 튜토리얼에 따라 Laravel 세션 기반 인증을 설정하는 단계별 가이드입니다.

## 현재 프로젝트 상태

✅ Laravel 프로젝트가 이미 설정되어 있습니다
✅ Laravel Breeze가 이미 설치되어 있습니다 (`composer.json` 확인)
✅ 인증 관련 라우트, 컨트롤러, 뷰가 이미 생성되어 있습니다

## 실행 단계

### 1. Sail 실행 (Docker 컨테이너 시작)

WSL 터미널에서 프로젝트 디렉토리로 이동한 후:

```bash
cd ~/mylara
./vendor/bin/sail up -d
```

또는 docker-compose를 직접 사용:

```bash
docker-compose up -d
```

이 명령어는 백그라운드에서 Docker 컨테이너들을 실행합니다 (웹 서버, MySQL, Redis 등).

### 2. JavaScript/CSS 파일 설치 및 빌드

Sail을 통해 npm 명령어 실행:

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

또는 로컬에 Node.js가 설치되어 있다면:

```bash
npm install
npm run dev
```

### 3. 데이터베이스 마이그레이션 실행

데이터베이스 테이블 생성:

```bash
./vendor/bin/sail artisan migrate
```

또는 로컬 PHP 환경이 있다면:

```bash
php artisan migrate
```

### 4. 웹사이트 접속 및 테스트

1. **웹사이트 접속**: 브라우저에서 `http://localhost` 접속
2. **회원가입**: 우측 상단의 "Register" 링크 클릭
   - Name: 이름 입력
   - Email Address: 이메일 주소 입력
   - Password: 비밀번호 입력 (8자 이상)
   - Confirm Password: 비밀번호 확인
   - REGISTER 버튼 클릭
3. **대시보드 확인**: 회원가입 성공 시 자동으로 대시보드로 이동하며 "You're logged in!" 메시지 확인
4. **로그아웃**: 우측 상단의 사용자 이름 클릭 → "Log Out" 선택
5. **로그인**: 우측 상단의 "Log in" 링크 클릭 → 이메일과 비밀번호 입력 → LOG IN 버튼 클릭

## 코드 구조 이해하기

### 주요 파일들

1. **routes/auth.php**: 인증 관련 라우트 정의
   - `/login`, `/register`, `/logout` 등의 URL 정의

2. **routes/web.php**: 메인 라우트 파일
   - `/dashboard` 라우트에 `middleware(['auth', 'verified'])` 적용
   - `auth` 미들웨어는 로그인하지 않은 사용자의 접근을 차단

3. **resources/views/auth/login.blade.php**: 로그인 화면
   - 사용자가 보는 로그인 폼

4. **app/Http/Controllers/Auth/AuthenticatedSessionController.php**: 로그인 처리 핵심
   - `store()` 메서드에서 로그인 로직 처리
   - `$request->authenticate()`: 사용자 인증 시도
   - `$request->session()->regenerate()`: 세션 재생성 (보안 강화)

## 핵심 개념 정리

### 세션과 쿠키
- **세션**: 서버가 발급하는 "출입증" (Session ID)
- **쿠키**: 브라우저가 세션 ID를 저장하는 작은 보관함
- 로그인 시 서버가 세션 ID를 발급하고, 브라우저는 이를 쿠키에 저장하여 이후 요청마다 제시

### Laravel Breeze
- 복잡한 로그인 기능을 명령어 몇 번으로 자동 생성해주는 도구
- 라우트, 컨트롤러, 뷰를 자동으로 생성

### MVC 구조
- **Routes**: 주소(URL) 정의
- **Views**: 화면(HTML) 표시
- **Controllers**: 실제 동작 처리

### Auth 미들웨어
- 로그인하지 않은 사용자를 막아주는 "경비원" 역할
- `middleware(['auth'])`가 적용된 라우트는 로그인한 사용자만 접근 가능

## 문제 해결

### Docker/Sail 관련 문제
- Docker가 실행 중인지 확인: `docker ps`
- 컨테이너 로그 확인: `docker-compose logs`
- 컨테이너 재시작: `docker-compose restart`

### 데이터베이스 연결 문제
- `.env` 파일의 데이터베이스 설정 확인:
  ```
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=sail
  DB_PASSWORD=password
  ```

### npm 관련 문제
- `node_modules` 폴더 삭제 후 재설치: `rm -rf node_modules && npm install`

## 다음 단계

이제 기본적인 세션 기반 인증이 완료되었습니다! 추가로 학습할 수 있는 내용:

- 세션 저장소 설정 (파일, 데이터베이스, Redis 등)
- 사용자 프로필 관리
- 비밀번호 재설정 기능
- 이메일 인증 기능
- 권한 관리 (Authorization)

