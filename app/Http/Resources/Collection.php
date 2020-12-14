<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $meta = json_decode($request->get('meta'), true);
        $data = $this->collection;

        //Sort
        if(Arr::has($meta, 'sort')){
            $sortField = Arr::get($meta,  'sort.field', 'id');
            $sortAsc = Arr::get($meta,  'sort.asc', true);
            $data = $data->sortBy($sortField, null,!$sortAsc);
        }

        return $data->toArray();
    }
}
