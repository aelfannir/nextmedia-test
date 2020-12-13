<?php

namespace App\Console\Commands;

use App\services\ProductService;
use Illuminate\Console\Command;

class DeleteProduct extends Command
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

    public function handle(ProductService $service)
    {
        $helper = new CommandHelper($this);
        $id = $helper->askForChoice($service->all(), "Product to delete?");

        if(!is_null($id)){
            $service->delete($id);
            $this->info("Deleted !");
        }else{
            if($this->confirm("List is empty ! Would you like to create new product ?")){
                $this->call('product:create');
            }
        }
    }
}
