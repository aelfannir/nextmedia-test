<?php

declare(strict_types=1);

namespace App\Console\Commands\Category;

use App\Console\Commands\AppCommand;
use App\Services\Category\CategoryService;

/**
 * Class CreateCategory
 * @package App\Console\Commands\Category
 */
class CategoryCommand extends AppCommand
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryCommand constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct();
    }
}
