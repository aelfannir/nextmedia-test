<?php

namespace App\Http\Controllers;

use App\Product;
use App\services\ProductService;

class ProductController extends Controller
{
    public function __construct(ProductService $service)
    {
        parent::__construct($service);
    }
}
