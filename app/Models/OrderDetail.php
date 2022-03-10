<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'amount'
    ];
    
    protected $hidden = [
        
    ];

    public $queryable = [
        'id',
    ];

    protected $casts = [
        'price' => "double",
        'quantity' => "int",
        'amount' => "double"
    ];

    protected $relationship = [
        'order' => [
            'model' => "App\\Models\\Order",
        ],
        'product' => [
            'model' => "App\\Models\\Product"
        ],
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
