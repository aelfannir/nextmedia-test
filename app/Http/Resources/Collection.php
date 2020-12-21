<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

/**
 * Class Collection
 * @package App\Http\Resources
 */
class Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $meta = $request->meta;
        $data = $this->collection;

        //Sort
        if (Arr::has($meta, 'sort')) {
            $sortField = Arr::get($meta,  'sort.field', 'id');
            $sortAsc = Arr::get($meta,  'sort.asc', true);
            $data = $data->sortBy($sortField, null,!$sortAsc);
        }

        return $data->toArray();
    }
}
