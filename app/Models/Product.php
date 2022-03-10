<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BaseModel;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active',
    ];
    
    protected $hidden = [
        
    ];

    public $queryable = [
        'id'
    ];

    protected $casts = [
        'is_active' => "boolean",
        'price' => "double"
    ];

    protected $relationship = [
        'orders' => [
            'model' => "App\\Models\\OrderDetail",
        ],
        'orders.product' => [
            'model' => "App\\Models\\OrderDetail",
        ],
    ];

    public function scopeActive($query){
        $query->where('is_active',1);
    }

    public function orders(){
        return $this->hasMany(OrderDetail::class, 'product_id');
    }
}
