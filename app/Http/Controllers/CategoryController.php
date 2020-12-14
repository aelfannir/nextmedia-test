<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\services\CategoryService;

class CategoryController extends Controller
{
    public $collection = CategoryCollection::class;

    public function __construct(CategoryService $service)
    {
        parent::__construct($service);
    }
}
