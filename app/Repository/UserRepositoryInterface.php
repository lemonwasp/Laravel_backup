<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;

/**
 * 사용자 데이터에 접근하기 위한 계약(규칙)
 */
interface UserRepositoryInterface
{
    /**
     * 사용자 ID로 사용자 조회
     * 
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User;

    /**
     * 이메일로 사용자 조회
     * 
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * 새 사용자 생성
     * 
     * @param array $userData
     * @return User
     */
    public function create(array $userData): User;

    /**
     * 사용자 정보 업데이트
     * 
     * @param int $userId
     * @param array $userData
     * @return bool
     */
    public function update(int $userId, array $userData): bool;

    /**
     * 사용자 삭제
     * 
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool;
}




