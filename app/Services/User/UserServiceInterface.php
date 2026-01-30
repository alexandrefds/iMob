<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function createUser(array $data): User;

    public function getUserById(int $id): ?User;

    public function getUserByEmail(string $email): ?User;

    public function listUsersPaginated(int $perPage = 15): LengthAwarePaginator;

    public function updateUser(int $id, array $data): ?User;

    public function deleteUser(int $id): bool;
}
