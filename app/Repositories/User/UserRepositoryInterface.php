<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;

    public function findUserById(int $id): ?User;

    public function findUserByEmail(string $email): ?User;

    public function paginateUsers(int $perPage = 15): LengthAwarePaginator;

    public function updateUser(int $id, array $data): ?User;

    public function deleteUser(int $id): bool;
}
