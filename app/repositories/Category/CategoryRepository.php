<?php
declare(strict_types=1);

namespace App\Repositories\Category;

use App\Category;
use App\Repositories\AppRepository;
use Illuminate\Support\Collection;

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

    /**
     * Get all of the models from the database.
     *
     * @param array|mixed $columns
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'], $relations = [])
    {
        return Category::all();
    }
}
