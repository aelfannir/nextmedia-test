<?php
declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Services\Category\CategoryService;
use Illuminate\Http\Response;

/**
 * Class CategoryController
 * @package App\Http\Category
 */
class CategoryController extends Controller
{
    /**
     * @var string
     */
    public $collection = CategoryCollection::class;

    /**
     * CategoryController constructor.
     * @param CategoryService $productService
     */
    public function __construct(CategoryService $productService)
    {
        parent::__construct($productService);
    }
}
