<?php

namespace Accordous\Http\Controllers;

use Accordous\Contract;
use Accordous\Http\Requests\ContractRequest;
use Accordous\Repositories\ContractRepositoryInterface;

class ContractsController extends Controller
{
    private $contractRepository;

    public function __construct(ContractRepositoryInterface $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function index()
    {
        $contracts = $this->contractRepository->all();

        return response()->json($contracts, 200);
    }

    public function store(ContractRequest $request)
    {
        $contract = $this->contractRepository->create($request->all());

        return response()->json($contract, 201);
    }

    public function show(int $id)
    {
        return $this->contractRepository->find($id);
    }

    public function update(ContractRequest $request, int $id)
    {
        $contract = $this->contractRepository->find($id);
        $contract->update($request->all());
        $contract->save();

        return response()->json($contract, 200);
    }

    public function destroy(int $id)
    {
        $this->contractRepository->delete($id);

        return response()->json(null, 204);
    }

}
