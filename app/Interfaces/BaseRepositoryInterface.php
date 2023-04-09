<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Create
     */

    /**
     * Create a new model
     * @param array<string, mixed> $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Read
     */

    /**
     * Get all models
     * @param array<string> $columns
     * @param array<string> $relations
     * @return Collection
     */
    public function find(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Find a model by id.
     * @param string $id
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Model
     */
    public function findById(string $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    /**
     * Find all models that match the given fields.
     * @param array<string, mixed> $fieldValues
     * @param array<string, mixed> $values
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Collection
     */
    public function findBy(array $fieldValues, array $columns = ['*'], array $relations = [], array $appends = []): Collection;


    /**
     * Find a model by a given field.
     * @param array<string, mixed> $fieldValues
     * @param string $value
     * @param array<string> $columns
     * @param array<string> $relations
     * @param array<string, mixed> $appends
     * @return Model
     */
    public function findOneBy(array $fieldValues, array $columns = ['*'], array $relations = [], array $appends = []): ?Model;

    /**
     * Update
     */
    /**
     * Update a model
     * @param string $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(string $id, array $data): bool;

    /**
     * Delete
     */
    /**
     * Delete a model
     * @param string $id
     * @return bool
     */
    public function deleteById(string $id): bool;
}