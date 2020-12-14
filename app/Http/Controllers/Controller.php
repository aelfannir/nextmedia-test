<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collection;
use App\services\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response(new Collection($this->service->all()));
    }

    public function show($id)
    {
        $model = $this->service->find($id);
        return response($model, $model ? Response::HTTP_OK : Response::HTTP_NOT_FOUND);
    }

    public function store(Request $request)
    {
        return response(
            $this->service->save($request->request->all()),
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $id)
    {
        $model = $this->service->update($request->request->all(), $id);
        return response(
            $model,
            $model ? Response::HTTP_ACCEPTED : Response::HTTP_NOT_FOUND
        );
    }

    public function destroy($id)
    {
        $model = $this->service->delete($id);
        return response(
            null,
            $model ? Response::HTTP_NO_CONTENT : Response::HTTP_NOT_FOUND
        );
    }
}
