<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Interfaces\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(readonly User $userModel)
    {
    }

    public function store(array $data): void
    {
        $this->userModel->create($data);
    }
}
