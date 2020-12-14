<?php


namespace App\repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class Repository
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
    public function __construct(Model $model) {
        $this->model = $model;
    }


    /** Get all.
     *
     * @return Collection
     */
    public function all(): Collection {
        return $this->model::all();
    }

    /** Get model by id.
     *
     * @param $id
     * @return Collection|null
     */
    public function find($id) {
        return $this->model::find($id);
    }

    /** Save model.
     *
     * @param array $data
     * @return Collection
     */
    public function save(array $data)
    {
        $model = new $this->model($data);
        $model->save();
        return $model->fresh();
    }

    /** Update model.
     *
     * @param array $data
     * @param $id
     * @return Collection
     */
    public function update(array $data, $id)
    {

        $model = $this->find($id);
        if(!$model){
            throw new ModelNotFoundException();
        }

        $model->update($data);

        return $model;
    }

    /** Delete model.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->model::destroy($id);
    }

}
