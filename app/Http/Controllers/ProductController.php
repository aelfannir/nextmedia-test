<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\services\ProductService;

class ProductController extends Controller
{
    public $collection = ProductCollection::class;

    public function __construct(ProductService $service)
    {
        parent::__construct($service);
    }
}
