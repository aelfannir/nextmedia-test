<?php
declare(strict_types=1);

namespace App\Repositories\Product;

use App\Product;
use App\Repositories\AppRepository;

/**
 * Class ProductAppRepository
 * @package App\Repositories
 */
class ProductRepository extends AppRepository
{
    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
}
