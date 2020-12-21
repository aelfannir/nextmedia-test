<?php
declare(strict_types=1);

namespace App\Console\Commands\Product;

/**
 * Class DeleteProduct
 * @package App\Console\Commands\Product
 */
class DeleteProduct extends ProductCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete product by id';


    public function handle()
    {
        $products = $this->productService->all(['id','name']);
        if ($products->isEmpty() && $this->confirm("No product found! Would you like to create new product ?")) {
            $this->call('product:create');
        }

        $id = $this->askForChoice('Product to delete ?', $products);
        if ($id) {
            $this->productService->delete($id);
            $this->info('Deleted !');
        }
    }
}
