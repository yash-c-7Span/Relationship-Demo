<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\OrderDetail\Collection as OrderDetailCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResourceFilterable;

class Resource extends JsonResource
{
    use ResourceFilterable;
    protected $model = 'Product';

    public function toArray($request)
    {
        $data =  $this->fields();
        $data['orders'] = new OrderDetailCollection($this->whenLoaded('orders'));
        
        return $data;
    }
}
