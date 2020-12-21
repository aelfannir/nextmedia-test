<?php
declare(strict_types=1);

namespace App\Console\Commands\Category;

/**
 * Class DeleteCategory
 * @package App\Console\Commands\Category
 */
class DeleteCategory extends CategoryCommand
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

    public function handle()
    {
        $categories = $this->categoryService->all(['id','name']);
        if ($categories->isEmpty() && $this->confirm("No category found! Would you like to create new category ?")) {
            $this->call('product:create');
        }

        $id = $this->askForChoice('Category to delete ?', $categories);
        if ($id) {
            $this->categoryService->delete($id);
            $this->info('Deleted !');
        }
    }
}
