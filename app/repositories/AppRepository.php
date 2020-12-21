<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Class AppRepository
 * @package App\Repositories
 */
class AppRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Get all of the models from the database.
     *
     * @param array|mixed $columns
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'], $relations = []): Collection
    {
        return $this->model::all($columns)->load($relations);
    }

    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function find($id, array $columns = ['*'], $relations = []): ?Model
    {
        return $this->model::with($relations)->find($id, $columns);
    }

    /** Save model.
     *
     * @param array $attributes
     * @return Model|null
     */
    public function save(array $attributes): ?Model
    {
        $model = new $this->model($attributes);
        $model->save();

        return $model->fresh();
    }

    /** Update model.
     *
     * @param array $attributes
     * @param $id
     * @return Model|null
     */
    public function update(array $attributes, $id): ?Model
    {
        $model = $this->find($id);

        if (! $model) {
            throw new ModelNotFoundException();
        }
        $model->update($attributes);

        return $model;
    }

    /**
     * Destroy the models for the given IDs.
     *
     * @param  \Illuminate\Support\Collection|array|int|string  $ids
     * @return int
     */
    public function delete($ids): int
    {
        return $this->model::destroy($ids);
    }
}
