#!/bin/bash

# API 토큰 테스트 스크립트
# 사용법: ./test-api-token.sh <토큰>

TOKEN=$1

if [ -z "$TOKEN" ]; then
    echo "사용법: ./test-api-token.sh <토큰>"
    echo ""
    echo "예시:"
    echo "  ./test-api-token.sh 1|34s6LU5efe7D2ZeEt9xBr8Pi474ntPrECmHoFt9Kcb11a599"
    exit 1
fi

echo "=========================================="
echo "API 토큰 인증 테스트"
echo "=========================================="
echo ""

echo "1. 토큰 없이 API 호출 (실패 예상):"
echo "-----------------------------------"
curl -X GET http://localhost/api/user \
  -H "Accept: application/json" \
  -w "\nHTTP Status: %{http_code}\n"
echo ""
echo ""

echo "2. 토큰과 함께 API 호출 (성공 예상):"
echo "-----------------------------------"
curl -X GET http://localhost/api/user \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -w "\nHTTP Status: %{http_code}\n"
echo ""
echo ""

echo "=========================================="
echo "테스트 완료!"
echo "=========================================="

