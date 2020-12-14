<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;

class ProductCollection extends Collection
{
    public function toArray($request)
    {
        $category_id = Arr::get(
            json_decode($request->get('meta'), true),
            "filters.category_id"
        );

        if($category_id){
            $this->collection = $this->collection->filter(function ($value) use ($category_id){
                return $value->categories->pluck('id')->contains($category_id);
            });
        }

        return parent::toArray($request);
    }
}
