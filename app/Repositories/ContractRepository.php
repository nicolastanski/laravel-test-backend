<?php

namespace Accordous\Repositories;

use Accordous\Contract;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractRepository implements ContractRepositoryInterface
{
    protected $model;

    public function __construct(Contract $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('property')->get();
    }

    public function find(int $id)
    {
        $contract = $this->model->find($id)->with('property')->get();

        if (!$contract) {
            throw new ModelNotFoundException("Contract not found", 404);
        }

        return $contract;
    }

    public function create($data)
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
