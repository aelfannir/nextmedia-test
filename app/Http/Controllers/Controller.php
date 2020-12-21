<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Collection;
use App\Services\AppService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @var AppService
     */
    public $service;

    /**
     * @var string
     */
    public $collection = Collection::class;

    /**
     * Controller constructor.
     * @param AppService $service
     */
    public function __construct(AppService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response(
            new $this->collection($this->service->all())
        );
    }

    /**
     * get the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $model = $this->service->find($id);
        $status = $model ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        return response($model, $status);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $savedModel = $this->service->save($request->all());

        return response($savedModel, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function update(Request $request, int $id): Response
    {
        $model = $this->service->update($request->all(), $id);
        $status = $model ? Response::HTTP_ACCEPTED : Response::HTTP_NOT_FOUND;

        return response($model, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws \Throwable
     */
    public function destroy(int $id): Response
    {
        $deleted = $this->service->delete($id);
        $status = $deleted ? Response::HTTP_NO_CONTENT : Response::HTTP_NOT_FOUND;

        return response(null, $status );
    }
}
