<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
        'user_id',
        'guests',
        'date',
        'time',
        'status',
    ];

    /**
     * Cast database values to useful PHP types.
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Reservation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

