#!/bin/bash
cd /home/jit/mylara

echo "=== JWT 인증 테스트 ==="
echo ""

# 사용자 확인 및 생성
echo "1. 사용자 확인/생성..."
php artisan tinker <<'PHPEOF'
$user = App\Models\User::where('email', 'test@example.com')->first();
if (!$user) {
    $user = App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password123')
    ]);
    echo "사용자 생성: test@example.com\n";
} else {
    echo "사용자 존재: test@example.com\n";
}
PHPEOF

echo ""
echo "2. 로그인 테스트..."
curl -s -X POST http://localhost/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}' | head -20

echo ""
echo ""
echo "테스트 완료! 위의 응답에서 access_token을 확인하세요."

