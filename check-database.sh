#!/bin/bash

echo "=========================================="
echo "데이터베이스 확인"
echo "=========================================="
echo ""

echo "1. Users 테이블 확인:"
./vendor/bin/sail artisan tinker --execute="\App\Models\User::all(['id', 'name', 'email'])->each(fn(\$u) => print(\$u->id . ' | ' . \$u->name . ' | ' . \$u->email . PHP_EOL));"

echo ""
echo "2. Personal Access Tokens 테이블 확인:"
./vendor/bin/sail artisan tinker --execute="\Laravel\Sanctum\PersonalAccessToken::all(['id', 'tokenable_id', 'name', 'created_at'])->each(fn(\$t) => print(\$t->id . ' | User ID: ' . \$t->tokenable_id . ' | Name: ' . \$t->name . ' | Created: ' . \$t->created_at . PHP_EOL));"

echo ""
echo "=========================================="
echo "완료!"
echo "=========================================="

