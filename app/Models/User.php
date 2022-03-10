<?php

namespace App\Models;

use App\Traits\BaseModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, BaseModel;

    const ADMIN_ROLE = "ADMIN";
    const USER_ROLE = "USER";
    const STATUS = [
        'ACTIVE' => 1,
        'IN_ACTIVE' => 0,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_view',
        'is_active',
        'role'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
        'password_view'
    ];

    public $queryable = [
        'id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    protected $relationship = [
        'orders' => [
            'model' => "App\Models\Order",
        ],
        'orders.details' => [
            'model' => "App\Models\Order",
        ],
        'orders.details.product' => [
            'model' => "App\Models\Order",
        ],
    ];

    public function orders(){
        return $this->hasMany(Order::class, 'user_id');
    }
}
