#!/bin/bash

echo "=== JWT 인증 테스트 ==="
echo ""

# 1. 사용자 생성/확인
echo "1. 사용자 생성/확인 중..."
./vendor/bin/sail artisan tinker --execute="
\$user = App\Models\User::firstOrCreate(
    ['email' => 'test@example.com'],
    ['name' => 'Test User', 'password' => bcrypt('password123')]
);
echo 'User: ' . \$user->email . PHP_EOL;
"

echo ""
echo "2. 로그인 테스트 중..."
# 2. 로그인 테스트
LOGIN_RESPONSE=$(curl -s -X POST http://localhost/api/auth/login \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -d '{"email":"test@example.com","password":"password123"}')

echo "로그인 응답:"
echo "$LOGIN_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$LOGIN_RESPONSE"
echo ""

# 3. 토큰 추출
TOKEN=$(echo "$LOGIN_RESPONSE" | grep -o '"access_token":"[^"]*' | cut -d'"' -f4)

if [ -z "$TOKEN" ]; then
    echo "❌ 토큰을 받지 못했습니다. 로그인에 실패한 것 같습니다."
    exit 1
fi

echo "✅ 토큰 받기 성공!"
echo "토큰: ${TOKEN:0:50}..."
echo ""

# 4. 인증된 사용자 정보 가져오기
echo "3. 인증된 사용자 정보 가져오기..."
USER_INFO=$(curl -s -X POST http://localhost/api/auth/me \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $TOKEN")

echo "사용자 정보:"
echo "$USER_INFO" | python3 -m json.tool 2>/dev/null || echo "$USER_INFO"
echo ""

# 5. 로그아웃 테스트
echo "4. 로그아웃 테스트..."
LOGOUT_RESPONSE=$(curl -s -X POST http://localhost/api/auth/logout \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $TOKEN")

echo "로그아웃 응답:"
echo "$LOGOUT_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$LOGOUT_RESPONSE"
echo ""

echo "=== 테스트 완료 ==="

