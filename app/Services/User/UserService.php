<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Cache;

class UserService implements UserServiceInterface
{
    private const CACHE_PREFIX = 'users:';
    private const VERSION_KEY = 'users:ver';

    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function createUser(array $data): User
    {
        $user = $this->repository->createUser($data);

        $this->forgetUserCaches($user->id, $user->email);
        $this->bumpCacheVersion();

        return $user;
    }

    public function getUserById(int $id): ?User
    {
        $cache = $this->cache();
        $ttl = $this->cacheTtl();
        $key = self::CACHE_PREFIX.'id:'.$id;

        return $cache->remember($key, $ttl, fn () => $this->repository->findUserById($id));
    }

    public function getUserByEmail(string $email): ?User
    {
        $cache = $this->cache();
        $ttl = $this->cacheTtl();
        $key = self::CACHE_PREFIX.'email:'.$email;

        return $cache->remember($key, $ttl, fn () => $this->repository->findUserByEmail($email));
    }

    public function listUsersPaginated(int $perPage = 15): LengthAwarePaginator
    {
        $cache = $this->cache();
        $ttl = $this->cacheTtl();
        $page = Paginator::resolveCurrentPage();
        $version = $this->getCacheVersion();
        $key = self::CACHE_PREFIX.'ver:'.$version.':page:'.$perPage.':'.$page;

        return $cache->remember($key, $ttl, fn () => $this->repository->paginateUsers($perPage));
    }

    public function updateUser(int $id, array $data): ?User
    {
        $existing = $this->repository->findUserById($id);
        if ($existing === null) {
            return null;
        }

        $user = $this->repository->updateUser($id, $data);
        if ($user === null) {
            return null;
        }

        $this->forgetUserCaches($id, $existing->email);
        if ($user->email !== $existing->email) {
            $this->forgetUserCaches($id, $user->email);
        }

        $this->bumpCacheVersion();

        return $user;
    }

    public function deleteUser(int $id): bool
    {
        $existing = $this->repository->findUserById($id);
        if ($existing === null) {
            return false;
        }

        $deleted = $this->repository->deleteUser($id);
        if (!$deleted) {
            return false;
        }

        $this->forgetUserCaches($id, $existing->email);
        $this->bumpCacheVersion();

        return true;
    }

    private function cache(): CacheRepository
    {
        return Cache::store('redis');
    }

    private function cacheTtl(): int
    {
        return (int) config('cache_ttl.users', 300);
    }

    private function getCacheVersion(): int
    {
        $cache = $this->cache();
        $version = $cache->get(self::VERSION_KEY);

        if (is_int($version)) {
            return $version;
        }

        if (is_numeric($version)) {
            return (int) $version;
        }

        $cache->forever(self::VERSION_KEY, 1);

        return 1;
    }

    private function bumpCacheVersion(): int
    {
        return (int) $this->cache()->increment(self::VERSION_KEY);
    }

    private function forgetUserCaches(int $id, string $email): void
    {
        $cache = $this->cache();

        $cache->forget(self::CACHE_PREFIX.'id:'.$id);
        $cache->forget(self::CACHE_PREFIX.'email:'.$email);
    }
}
