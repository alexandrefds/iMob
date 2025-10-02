<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\Repositories\BaseRepositoryInterface;
use App\Interfaces\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(readonly private User $userModel)
    {
    }

    public function store(array $data): void
    {
        $this->userModel
            ->create($data);
    }
}
