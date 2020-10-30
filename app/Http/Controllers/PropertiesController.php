<?php

namespace Accordous\Http\Controllers;

use Accordous\Http\Requests\PropertyRequest;
use Accordous\Repositories\PropertyRepositoryInterface;
use \Illuminate\Database\Eloquent\ModelNotFoundException;

class PropertiesController extends Controller
{
    private $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function index()
    {
        $properties = $this->propertyRepository->all();
        return response()->json($properties, 200);
    }

    public function store(PropertyRequest $request)
    {
        $property = $this->propertyRepository->create($request->all());

        return response()->json($property, 201);
    }

    public function show(int $id)
    {
        return $this->propertyRepository->find($id);
    }

    public function update(PropertyRequest $request, int $id)
    {
        $property = $this->propertyRepository->find($id);
        $property->update($request->all());
        $property->save();

        return response()->json($property, 200);
    }

    public function destroy(int $id)
    {
        $property = $this->propertyRepository->find($id);

        $property->delete();
    }
}
