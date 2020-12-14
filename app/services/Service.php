<?php

namespace App\services;

use App\repositories\Repository;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class Service
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $save_validation_rules = [];

    /**
     * @var array
     */
    protected $update_validation_rules = [];

    /**
     * Service constructor.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $name
     * @return array
     */
    public function getSaveValidationRule($name): array
    {
        return Arr::get($this->getSaveValidationRules(), $name, []);
    }

    /**
     * @return array
     */
    public function getSaveValidationRules(): array
    {
        return $this->save_validation_rules;
    }

    /**
     * @return array
     */
    public function getUpdateValidationRules(): array
    {
        return $this->update_validation_rules;
    }

    /** Get model by id.
     *
     * @return Collection
     */
    public function all() : Collection
    {
        return $this->repository->all();
    }

    /** Get model by id.
     *
     * @param $id
     * @return Collection|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /** Save model.
     *
     * @param array $data
     * @return Collection
     */
    public function save(array $data)
    {
        $validator = Validator::make($data, $this->getSaveValidationRules());

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return $this->repository->save($data);
    }

    /** Update model.
     *
     * @param array $data
     * @param $id
     * @return Collection
     */
    public function update(array $data, $id)
    {
        $validator = Validator::make($data, $this->getUpdateValidationRules());

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $model = $this->repository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update model');
        }

        DB::commit();

        return $model;

    }

    /** Delete model.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $deleted = $this->repository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete model');
        }

        DB::commit();

        return $deleted;

    }


}
