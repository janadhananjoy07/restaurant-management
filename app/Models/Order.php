<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [ 'user_id', 'staff_id', 'cashfree_order_id', 'total_amount', 'status', 'payment_status', 'payment_method', 'payment_id', 'delivered_by', 'address', 'phone', 'latitude', 'longitude', 'feedback_prompt_dismissed_at', ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
