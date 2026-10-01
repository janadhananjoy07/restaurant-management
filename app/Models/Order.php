<?php

namespace App\Models;


use App\Models\Feedback;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'status',
        'total_amount',
        'address',
        'phone',
        'latitude',
        'longitude',
        'feedback_prompt_dismissed_at',
    ];

    protected $casts = [
        'feedback_prompt_dismissed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Staff
    |--------------------------------------------------------------------------
    */

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Feedback
    |--------------------------------------------------------------------------
    */

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'order_id');
    }
}

