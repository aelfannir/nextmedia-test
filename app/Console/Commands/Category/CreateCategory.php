<?php

declare(strict_types=1);

namespace App\Console\Commands\Category;

/**
 * Class CreateCategory
 * @package App\Console\Commands\Category
 */
class CreateCategory extends CategoryCommand
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
     */
    public function handle()
    {
        $data = [];
        $attributes['name'] = $this->ask('Name');

        $categories = $this->categoryService->all(['id','name']);
        $attributes['parent_id'] = $this->askForChoice('Parent category', $categories);

        $this->categoryService->save($data);
        $this->info("Saved !");
    }
}
