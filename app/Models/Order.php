<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, BaseModel;

    const STATUS = [
        'PENDING' => 1,
    ];

    protected $fillable = [
        'user_id',
        'address',
        'total',
        'status',
    ];

    protected $hidden = [];

    public $queryable = [
        'id',
    ];

    protected $casts = [
        'total' => "double",
    ];

    protected $relationship = [
        'details' => [
            'model' => "App\\Models\\OrderDetail"
        ],
        'details.order' => [
            'model' => "App\\Models\\OrderDetail"
        ],
        'details.product' => [
            'model' => "App\\Models\\OrderDetail"
        ],
        'user' => [
            'model' => "App\\Models\\User"
        ]
    ];

    public function getStatusAttribute(){
        $status = $this->attributes['status'];
        if($status == 1){
            $status = "Pending";
        }
        return $status;
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
