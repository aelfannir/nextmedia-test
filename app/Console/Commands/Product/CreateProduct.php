<?php
declare(strict_types=1);

namespace App\Console\Commands\Product;

use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;

/**
 * Class CreateProduct
 * @package App\Console\Commands
 */
class CreateProduct extends ProductCommand
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CreateProduct constructor.
     * @param ProductService $productService
     * @param CategoryService $categoryService
     */
    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct($productService);
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new product';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $attributes = [];
        $attributes['name'] = $this->ask('Name');
        $attributes['description'] = $this->ask('Description');
        $attributes['price'] = $this->ask('Price');
        $attributes['image'] = $this->askForFile('Image', $this->productService->uploadPath);

        $categories = $this->categoryService->all(['id','name']);
        $attributes['categoriesIds'] = $this->askForChoice('Categories', $categories, true);

        $this->productService->save($attributes);
        $this->info("Created !");
    }
}
