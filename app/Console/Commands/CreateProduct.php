<?php

namespace App\Console\Commands;

use App\Product;
use App\services\CategoryService;
use App\services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Builder;

class CreateProduct extends Command
{
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
     * @param ProductService $service
     * @param CategoryService $categoryService
     */
    public function handle(ProductService $service, CategoryService $categoryService)
    {
        $helper = new CommandHelper($this);

        $data = [
            'name'=> $helper->askWithValidation(
                'Name ?',
                'name',
                $service->getSaveValidationRule('name')
            ),
            'description'=> $helper->askWithValidation(
                'Description ?',
                'description',
                $service->getSaveValidationRule('description')
            ),
            'price' => $helper->askWithValidation(
                'Price ?',
                'price',
                $service->getSaveValidationRule('price')
            ),
            'image' => $helper->askForFile('Local image path (Optional)','public/products'),
            'categories_ids'=> $helper->askForChoice(
                $categoryService->all(),
                'Categories ? (Optional)',
                true
            )
        ];

        $product = $service->save($data);

        $this->info("{$product->name} product has been created");
    }
}
