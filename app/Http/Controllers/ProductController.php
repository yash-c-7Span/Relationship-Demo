<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\Product as ProductRequest;
use App\Http\Resources\Product\Collection as ProductCollection;
use App\Http\Resources\Product\Resource as ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index(Request $request)
    {
        $data = $this->productService->collection($request->all());
        return $this->collection(new ProductCollection($data));
    }

    public function store(ProductRequest $request)
    {
        $data = $this->productService->store((object) $request->validated());
        return $this->resource(new ProductResource($data));
    }

    public function show($id)
    {
        $data = $this->productService->resource($id);
        return $this->resource(new ProductResource($data));
    }

   
    public function update(ProductRequest $request, $id)
    {
        $data = $this->productService->update($id, (object) $request->validated());
        return $this->resource(new ProductResource($data));
    }

  
    public function destroy($id)
    {
        $data = $this->productService->delete($id);
        return $this->success($data,200);
    }
}
