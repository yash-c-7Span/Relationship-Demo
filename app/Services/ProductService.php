<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder;

class ProductService
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function collection($input = null)
    {
        $query = $this->product->getQB()->paginate();
        return $query;
    }

    public function store(object $input)
    {

        $data = $this->product->create([
            'name' => $input->name,
            'description' => $input->description,
            'price' => $input->price,
            'is_active' => $input->is_active
        ]);

        return $data;
    }

    public function resource(int $id)
    {
        $data = $this->product->getQB()->findOrFail($id);
        if (empty($data)) {
            throw new CustomException("Product Not Found.");
        }
        return $data;        
    }

    public function update(int $id, object $input)
    {
        $data = $this->resource($id);
        if (isset($data['error'])) {
            return $data;
        }

        $data->update([
            'name' => $input->name,
            'description' => $input->description,
            'price' => $input->price,
            'is_active' => $input->is_active,
        ]);

        return $data;
    }

    public function delete(int $id)
    {

        $data = $this->resource($id);
        if (isset($data['error'])) {
            return $data;
        }

        if($data->orders->count() < 1){
            $data = $data->delete();
            return ['success' => $data];
        }

        throw new CustomException("Product Cannot Delete, This Product Ordered Some Users.");
    }
}
