#!/bin/bash

TOKEN="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzYzNTE5MjY1LCJleHAiOjE3NjM1MjI4NjUsIm5iZiI6MTc2MzUxOTI2NSwianRpIjoid0FkMXlqek1aampLN2M3NSIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.5e8LDeib6o1CLnen6PfSxxgHEIJj9ltMg-A-uUl5rSQ"

echo "=== 제공하신 토큰으로 테스트 ==="
echo ""

echo "1. 사용자 정보 가져오기 (GET /api/auth/me)..."
curl -s -X POST http://localhost/api/auth/me \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $TOKEN" | python3 -m json.tool 2>/dev/null || curl -s -X POST http://localhost/api/auth/me -H 'Content-Type: application/json' -H 'Accept: application/json' -H "Authorization: Bearer $TOKEN"
echo ""
echo ""

echo "2. 토큰 갱신 (POST /api/auth/refresh)..."
curl -s -X POST http://localhost/api/auth/refresh \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $TOKEN" | python3 -m json.tool 2>/dev/null || curl -s -X POST http://localhost/api/auth/refresh -H 'Content-Type: application/json' -H 'Accept: application/json' -H "Authorization: Bearer $TOKEN"
echo ""
echo ""

echo "3. 로그아웃 (POST /api/auth/logout)..."
curl -s -X POST http://localhost/api/auth/logout \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H "Authorization: Bearer $TOKEN" | python3 -m json.tool 2>/dev/null || curl -s -X POST http://localhost/api/auth/logout -H 'Content-Type: application/json' -H 'Accept: application/json' -H "Authorization: Bearer $TOKEN"
echo ""
echo ""

echo "=== 테스트 완료 ==="

