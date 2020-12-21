<?php

declare(strict_types=1);

namespace App\Console\Commands\Product;

use App\Console\Commands\AppCommand;
use App\Services\Product\ProductService;

/**
 * Class CreateProduct
 * @package App\Console\Commands\Product
 */
class ProductCommand extends AppCommand
{
    protected $productService;

    /**
     * ProductCommand constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        parent::__construct();
    }
}
