<?php

namespace App\Http\Controllers;

use App\Repositories\BaseRepositoryInterface;

class BaseController extends Controller
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = $this->repository->find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $this->repository->create($request->all());
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repository->update($id, $request->all());
        return response()->json($data);
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json(null, 204);
    }
}
