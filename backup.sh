#!/bin/bash

# 기존 프로젝트 백업 스크립트
BACKUP_DIR="../mylara-backup-$(date +%Y%m%d-%H%M%S)"
CURRENT_DIR=$(pwd)

echo "백업 시작: $BACKUP_DIR"
mkdir -p "$BACKUP_DIR"

# 중요한 파일과 디렉토리만 백업 (vendor, node_modules 제외)
rsync -av --exclude='vendor' --exclude='node_modules' --exclude='.git' --exclude='storage/logs' --exclude='storage/framework/cache' --exclude='storage/framework/sessions' --exclude='storage/framework/views' --exclude='.env' . "$BACKUP_DIR/"

echo "백업 완료: $BACKUP_DIR"

