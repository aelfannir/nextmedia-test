<?php

namespace App\Console\Commands;

use App\Category;
use App\services\CategoryService;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Arr;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new category';

    /**
     * Execute the console command.
     * @param CategoryService $service
     */
    public function handle(CategoryService $service)
    {
        $helper = new CommandHelper($this);

        $data = [
            'name'=> $helper->askWithValidation(
                'Name ?',
                'name',
                $service->getSaveValidationRule('name')
            ),
            'parent_id'=> $helper->askForChoice(
                $service->all(),
                'Parent category\'s ID ? (Optional)'
            )
        ];

        $category = $service->save($data);
        $this->info("{$category->name} category has been created");
    }
}
