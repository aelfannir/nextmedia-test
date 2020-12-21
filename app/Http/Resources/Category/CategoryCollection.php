<?php
declare(strict_types=1);

namespace App\Http\Resources\Category;

use App\Http\Resources\Collection;

/**
 * Class CategoryCollection
 * @package App\Http\Resources\Category
 */
class CategoryCollection extends Collection
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
