<?php
declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCollection;
use App\Services\Product\ProductService;
use Illuminate\Http\Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\Category
 */
class ProductController extends Controller
{
    /**
     * @var string
     */
    public $collection = ProductCollection::class;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct($productService);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response(
            new $this->collection($this->service->all(['*'], ['categories']))
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
        //todo $with
        $model = $this->service->find($id, ['*'], ['categories']);
        $status = $model ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        return response($model, $status);
    }
}
