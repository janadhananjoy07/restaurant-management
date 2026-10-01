<?php

namespace App\Models;


use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $table = 'feedback';

    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
    'user_id',
    'order_id',
    'rating',
    'comment',
    'aspects',
    'images',
    'status',
];

    /**
     * Automatically cast database values.
     */
    protected function casts(): array
    {
        return [
            'rating'  => 'integer',
            'aspects' => 'array',
            'images'  => 'array',
        ];
    }

    /**
     * Feedback belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Feedback belongs to an order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}