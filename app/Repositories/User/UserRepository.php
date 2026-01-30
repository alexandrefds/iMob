<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $model)
    {
    }

    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    public function findUserById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function paginateUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage);
    }

    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->findUserById($id);
        if ($user === null) {
            return null;
        }

        $user->fill($data);
        $user->save();

        return $user;
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->findUserById($id);
        if ($user === null) {
            return false;
        }

        return (bool) $user->delete();
    }
}
