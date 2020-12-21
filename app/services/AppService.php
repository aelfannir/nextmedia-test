<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\AppRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * Class AppService
 * @package App\Services
 */
class AppService
{
    /**
     * @var AppRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $uploadPath = 'public';

    /**
     * Validation Rules for Save
     *
     * @var array
     */
    protected $saveRules = [];

    /**
     * Validation rules for update
     *
     * @var array
     */
    protected $updateRules = [];

    /**
     * Service constructor.
     *
     * @param AppRepository $repository
     */
    public function __construct(AppRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getSaveRules(): array
    {
        return $this->saveRules;
    }

    public function getUpdateRules(): array
    {
        return $this->updateRules;
    }

    /**
     * @param array $attributes
     * @param array $rules
     */
    public function validate(array $attributes, array $rules)
    {
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
    }

    /**
     * Get all of the models from the database.
     *
     * @param array|mixed $columns
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'], $relations = []) : Collection
    {
        return $this->repository->all($columns, $relations);
    }

    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function find($id, $columns = ['*'], $relations = []): ?Model
    {
        return $this->repository->find($id, $columns, $relations);
    }


    /**
     * @param array $attributes
     * @return Model
     */
    public function save(array $attributes): Model
    {
        $rules = $this->getSaveRules();
        $this->validate($attributes, $rules);

        $model = $this->repository->save($attributes);
        if (is_null($model)) {
            throw new InvalidArgumentException('Unable to save model');
        }

        return $model;
    }

    /** Validate & Update model.
     *
     * @param array $attributes
     * @param $id
     * @return Model
     * @throws \Throwable
     */
    public function update(array $attributes, $id): Model
    {
        $rules = $this->getUpdateRules();
        $this->validate($attributes, $rules);

        DB::beginTransaction();

        try {
            $model = $this->repository->update($attributes, $id);
            if (is_null($model)) {
                throw new Exception();
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new InvalidArgumentException('Unable to update model');
        }

        DB::commit();

        return $model;
    }

    /** Delete model.
     *
     * @param  \Illuminate\Support\Collection|array|int|string  $ids
     * @return int
     * @throws \Throwable
     */
    public function delete($ids): int
    {
        DB::beginTransaction();

        try {
            $count = $this->repository->delete($ids);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception('Unable to delete model(s)');
        }

        DB::commit();

        return $count;
    }

}
