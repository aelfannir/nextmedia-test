<?php

namespace App\services;

use App\Repositories\CategoryRepository;

class CategoryService extends Service
{
    /**
     * @var array
     */
    public $save_validation_rules = [
        'name' => ['required','max:255']
    ];

    /**
     * @var array
     */
    protected $update_validation_rules = [
        'name' => ['max:255']
    ];

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {

        parent::__construct($repository);
    }




}
