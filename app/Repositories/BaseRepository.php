<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\Cast\Void_;

class BaseRepository
{
    private Builder $query;

    public function __construct(readonly private Model $model)
    {
        $this->query = $model->newQuery();
    }

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function getByInd(int $id): Model
    {
        return $this->model
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->get();
    }

    public function index(): Collection
    {
        return $this->model
            ->whereNull('deleted_at')
            ->get();
    }

    public function update(int $id, array $newData): void
    {
        $data = $this->getByInd($id);

        $data->update($newData);

        $data->save();
     }

     public function destroy(int $id)
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->query
            ->whereNull('deleted_at')
            ->paginate($perPage, $columns);
    }


    public function indexWithTrash(): Collection
    {
        return $this->model
            ->get();
    }
}
