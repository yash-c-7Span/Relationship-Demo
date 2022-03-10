<?php

namespace App\Http\Resources\OrderDetail;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\OrderDetail\Resource';    
    public function toArray($request)
    {
        return $this->collection;
    }
}
