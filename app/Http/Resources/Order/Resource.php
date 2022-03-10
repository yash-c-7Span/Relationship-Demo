<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderDetail\Collection as OrderDetailCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Traits\ResourceFilterable;

class Resource extends JsonResource
{
    use ResourceFilterable;
    protected $model = 'Order';

    public function toArray($request)
    {
        $data =  $this->fields();
        $data['details'] = new OrderDetailCollection($this->whenLoaded('details'));
        
        return $data;
    }
}
