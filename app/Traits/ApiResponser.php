<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponser{

    protected function success($data, $code){
        return response()->json($data, $code);
    }

    protected function error($data, $code = 400){
        return response()->json($data, $code);
    }

    protected function resource(JsonResource $jsonResource, $code = 200){
        return $this->success($jsonResource, $code);
    }

    protected function collection(ResourceCollection $resourceCollection, $code = 200){
        return $resourceCollection;
    }


}