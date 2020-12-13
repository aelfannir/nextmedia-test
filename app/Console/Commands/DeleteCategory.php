<?php

namespace App\Console\Commands;

use App\services\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete category by id';


    public function handle(CategoryService $service)
    {
        $helper = new CommandHelper($this);
        $id = $helper->askForChoice($service->all(), "Category to delete?");

        if(!is_null($id)){
            $service->delete($id);
            $this->info("Deleted !");
        }else{
            if($this->confirm("List is empty ! Would you like to create new category ?")){
                $this->call('category:create');
            }
        }
    }
}
