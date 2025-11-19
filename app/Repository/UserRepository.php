<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\User;

/**
 * Eloquent를 사용하여 UserRepositoryInterface를 구현
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findById(int $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $userData): User
    {
        return User::create($userData);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $userId, array $userData): bool
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }
        
        return $user->update($userData);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $userId): bool
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }
        
        return $user->delete();
    }
}




