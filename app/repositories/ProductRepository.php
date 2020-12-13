<?php


namespace App\repositories;


use App\Product;

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
