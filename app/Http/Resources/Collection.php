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
        $meta = $request->get('meta', []);
        $data = $this->collection;

        //Sort
        if(Arr::has($meta, 'sort')){
            $sortField = Arr::get($meta,  'sort.field', 'id');
            $sortAsc = Arr::get($meta,  'sort.asc', true);
            $data = $data->sortBy($sortField, null,!$sortAsc);
        }

        //Filters, { category_id: 5, ... }
        if(Arr::has($meta, 'filters')){
            $filters = data_get($meta,"filters",[]);
            foreach ($filters as $filterKey=>$filterValue){
                $data = $data->where($filterKey, "=",$filterValue);
            }
        }

        return $data->toArray();
    }
}
