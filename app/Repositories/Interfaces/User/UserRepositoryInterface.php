<?php

namespace App\Repositories\Interfaces\User;

interface UserRepositoryInterface
{
    public function store(array $data): void;
}
