<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * 사용자 등록 비즈니스 로직
     * 
     * @param array $userData
     * @return User
     */
    public function registerUser(array $userData): User
    {
        // 1. 비밀번호 해싱
        $userData['password'] = Hash::make($userData['password']);
        
        // 2. 사용자 생성
        $user = $this->userRepository->create($userData);
        
        // 3. 회원가입 이벤트 발생
        event(new Registered($user));
        
        return $user;
    }

    /**
     * 사용자 인증 비즈니스 로직
     * 
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function authenticateUser(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);
        
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        
        return null;
    }

    /**
     * 사용자 ID로 사용자 조회
     * 
     * @param int $userId
     * @return User|null
     */
    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
}




