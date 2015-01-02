<?php namespace LaraSnipp\Repo;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository
{
    /**
     * Eloquent model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * Returns all records
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        $model = $this->model->create($data);

        if (!$model) {
            return false;
        }

        return true;
    }

    /**
     * Get single model by slug
     *
     * @param string slug
     * @return object object of model
     */
    public function bySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Updates the model with the provided input
     *
     * @param $model
     * @param array $input
     * @return mixed
     */
    public function update($model, array $input)
    {
        $model->fill($input);

        return $model->save();
    }
}
