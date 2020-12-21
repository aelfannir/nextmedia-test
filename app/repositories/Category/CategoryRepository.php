<?php
declare(strict_types=1);

namespace App\Repositories\Category;

use App\Category;
use App\Repositories\AppRepository;

/**
 * Class CategoryAppRepository
 * @package App\Repositories\Category
 */
class CategoryRepository extends AppRepository
{
    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }


}
