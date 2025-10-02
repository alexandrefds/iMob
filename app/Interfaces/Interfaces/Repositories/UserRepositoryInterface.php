<?php

namespace App\Interfaces\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function store(array $data): void;
}
