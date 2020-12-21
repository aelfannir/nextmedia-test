<?php
declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Http\Resources\Collection;
use Illuminate\Support\Arr;

/**
 * Class ProductCollection
 * @package App\Http\Resources
 */
class ProductCollection extends Collection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $category_id = Arr::get(
            $request->meta,
            "filters.category_id"
        );

        if ($category_id) {
            $this->collection = $this->collection->filter(function ($value) use ($category_id){
                return $value->categories->pluck('id')->contains($category_id);
            });
        }

        return parent::toArray($request);
    }
}
