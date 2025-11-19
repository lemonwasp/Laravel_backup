#!/bin/bash

# 새로운 Laravel 프로젝트 설치 스크립트
cd /home/jit

echo "새로운 Laravel 프로젝트 설치 시작..."
echo "프로젝트 이름: laravel-auth-example"

# Laravel.build 스크립트 실행
curl -s https://laravel.build/laravel-auth-example | bash

echo "설치 완료!"

