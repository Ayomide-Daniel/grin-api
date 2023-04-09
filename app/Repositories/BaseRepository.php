<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(
        private Model $model
    ) {}

    /**
     * Create a new model
     * @param array<string, mixed> $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Get all models
     * @param array<string> $columns
     * @param array<string> $relations
     * @return Collection
     */
    public function find(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Find a model by id.
     * @param string $id
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Model
     */
    public function findById(string $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->with($relations)->findOrFail($id, $columns)->append($appends);
    }

    /**
     * Find all models that match the given fields.
     * @param array<string, mixed> $fieldValues
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Collection
     */
    public function findBy(array $fieldValues, array $columns = ['*'], array $relations = [], array $appends = []): Collection
    {
        return $this->model->with($relations)->where($fieldValues)->get($columns)->append($appends);
    }

    /**
     * Find a model by a given fields.
     * @param array<string, mixed> $fieldValues
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Model
     */
    public function findOneBy(array $fieldValues, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->with($relations)->where($fieldValues)->first($columns)->append($appends);
    }

    /**
     * Update a model
     * @param string $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $model = $this->findById($id);

        return $model->update($data);
    }

    /**
     * Delete a model
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool
    {
        $model = $this->findById($id);

        return $model->delete();
    }

    /**
     * Restore a model
     * @param string $id
     * @return bool
     */
    public function restoreById(string $id): bool
    {
        $model = $this->findById($id);

        return $model->restore();
    }

    /**
     * Upsert a model
     * 
     * @param array<string, mixed> $data
     * @param array<string, mixed> $where
     * @return Model
     */
    public function upsert(array $data, array $where): Model
    {
        $model = $this->model->updateOrCreate($where, $data);

        return $model->fresh();
    }
}
