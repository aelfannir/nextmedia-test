<?php
declare(strict_types=1);

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use App\Services\AppService;

/**
 * Class CategoryService
 * @package App\Services\Category
 */
class CategoryService extends AppService
{
    /**
     * @var array
     */
    public $saveRules = [
        'name' => ['required','max:255']
    ];

    /**
     * @var array
     */
    protected $updateRules = [
        'name' => ['max:255']
    ];

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
    }

}
