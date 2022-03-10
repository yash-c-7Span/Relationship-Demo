<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder;

class OrderService
{

    private $order;
    private $product;
    private $orderDetail;
    private $productService;

    public function __construct(
        Order $order,
        OrderDetail $orderDetail,
        Product $product,
        ProductService $productService
    ) {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->product = $product;
        $this->productService = $productService;
    }

    public function collection($input = [])
    {
        $query = $this->order->getQB()->get();
        return $query;
    }

    public function resource(int $id)
    {
        $data = $this->order->getQB()->find($id);
        if (empty($data)) {
            throw new CustomException("Order Not Found.");
        }
        return $data;
    }
    
    /** 
     * User Order Method For User Role
     */

    public function productList($input = null)
    {
        $data = $this->product->getQB()->active()->paginate();
        return $data;
    }

    public function placeOrder(object $input)
    {
        DB::beginTransaction();
        $order = $this->order->create([
            'user_id' => auth()->id(),
            'address' => $input->address,
            'status' => Order::STATUS['PENDING'],
        ]);

        if (!empty($order)) {
            if (is_array($input->product_id)) {
                if (count($input->product_id) == count($input->quantity)) {
                    $count = 0;
                    $total = 0;
                    foreach ($input->product_id as $prodId) {
                        $product = $this->productService->resource($prodId);
                        $quantity = isset($input->quantity[$count]) ? $input->quantity[$count] : 0;
                        $amount = $product->price * $quantity;
                        $total += $amount;
                        $this->orderDetail->create([
                            'order_id' => $order->id,
                            'product_id' => $prodId,
                            'price' => $product->price,
                            'quantity' => $quantity,
                            'amount' => $amount,
                        ]);
                        $count++;
                    }

                    $order->update([
                        'total' => $total,
                    ]);
                    DB::commit();

                    return $order;
                } else {
                    throw new CustomException("Given Data Was Invalid, Please Check.");
                }
            }
            throw new CustomException("Given Data Was Invalid, Please Check.");
        }

        throw new CustomException("Something Wrong Please Try Again.");
    }
}
