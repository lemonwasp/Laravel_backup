#!/bin/bash

cd /home/jit/mylara

echo "=== JWT 인증 테스트 ==="
echo ""

# 1. 사용자 확인 및 생성
echo "1. 사용자 확인 중..."
php artisan tinker <<EOF
\$user = App\Models\User::first();
if (\$user) {
    echo "사용자 발견: " . \$user->email . "\n";
} else {
    echo "사용자가 없습니다. 테스트 사용자를 생성합니다...\n";
    \$user = App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password123')
    ]);
    echo "사용자 생성 완료: " . \$user->email . "\n";
}
EOF

echo ""
echo "2. 로그인 API 테스트 중..."
echo ""

# 2. 로그인 테스트
LOGIN_RESPONSE=$(curl -s -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com", "password": "password123"}')

echo "로그인 응답:"
echo "$LOGIN_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$LOGIN_RESPONSE"
echo ""

# 토큰 추출
TOKEN=$(echo "$LOGIN_RESPONSE" | grep -o '"access_token":"[^"]*' | cut -d'"' -f4)

if [ -z "$TOKEN" ]; then
    echo "❌ 토큰을 받지 못했습니다. 로그인에 실패했을 수 있습니다."
    exit 1
fi

echo "✅ 토큰 받기 성공!"
echo "토큰: ${TOKEN:0:50}..."
echo ""

# 3. 내 정보 조회 테스트
echo "3. 내 정보 조회 API 테스트 중..."
echo ""

ME_RESPONSE=$(curl -s -X POST http://localhost/api/auth/me \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "내 정보 응답:"
echo "$ME_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$ME_RESPONSE"
echo ""

# 4. 로그아웃 테스트
echo "4. 로그아웃 API 테스트 중..."
echo ""

LOGOUT_RESPONSE=$(curl -s -X POST http://localhost/api/auth/logout \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json")

echo "로그아웃 응답:"
echo "$LOGOUT_RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$LOGOUT_RESPONSE"
echo ""

echo "=== 테스트 완료 ==="

