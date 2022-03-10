<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\PlaceOrder as PlaceOrderRequest;
use App\Http\Resources\Order\Resource as OrderResource;
use App\Http\Resources\Order\Collection as OrderCollection;
use App\Http\Resources\Product\Collection as ProductCollection;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $data = $this->orderService->collection($request->all());
        return $this->collection(new OrderCollection($data));
    }

   
    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $data = $this->orderService->resource($id);
        return $this->resource(new OrderResource($data));
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    /** 
     * User Order Methods For User Role
     */

    public function productList(Request $request){
        $data = $this->orderService->productList($request->all());
        return $this->collection(new ProductCollection($data));
    }
    public function placeOrder(PlaceOrderRequest $request){
        $order = $this->orderService->placeOrder((object) $request->validated());
        return $this->resource(new OrderResource($order));
    }
}
