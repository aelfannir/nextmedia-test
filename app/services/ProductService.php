<?php

namespace App\services;

use App\Repositories\ProductRepository;

class ProductService extends Service
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
     * ProductService constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }




}
