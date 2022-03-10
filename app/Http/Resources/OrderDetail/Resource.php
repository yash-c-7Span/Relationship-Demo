<?php

namespace App\Http\Resources\OrderDetail;

use App\Http\Resources\Product\Resource as ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResourceFilterable;

class Resource extends JsonResource
{
    use ResourceFilterable;
    protected $model = 'OrderDetail';

    public function toArray($request)
    {
        $data =  $this->fields();
        $data['product'] = new ProductResource($this->whenLoaded('product'));
        return $data;
    }
}
