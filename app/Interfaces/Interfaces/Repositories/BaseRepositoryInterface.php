<?php

namespace App\Interfaces\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function store(array $data): Model;

    public function getByInd(int $id): Model;

    public function index(): Collection;

    public function update(int $id, array $newData): void;

    public function destroy(int $id): void;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function indexWithTrash(): Collection;
}
