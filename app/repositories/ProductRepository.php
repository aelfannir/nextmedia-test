<?php


namespace App\repositories;


use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductRepository extends Repository
{

    /**
     * ProductRepository constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

}
