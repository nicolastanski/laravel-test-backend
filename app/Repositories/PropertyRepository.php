<?php

namespace Accordous\Repositories;

use Accordous\Property;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertyRepository implements PropertyRepositoryInterface
{
    protected $model;

    public function __construct(Property $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('contract')->get();
    }

    public function find(int $id)
    {
        $property = $this->model->find($id);

        if (!$property) {
            throw new ModelNotFoundException("Property not found", 404);
        }

        return $property;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $property = $this->find($id);

        return $property->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}
