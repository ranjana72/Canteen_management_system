<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ✅ Columns that are safe to fill via create() or update()
    protected $fillable = [

        'user_id',
        'order_number',
        'status',
        'total_amount',
        'note',
        'phone',
        'ready_at',

    ];

    // 🔄 Auto-cast these columns to proper PHP types
    protected $casts = [
        'total_amount' => 'decimal:2',   // Always 2 decimal places e.g. 150.00
        'ready_at'     => 'datetime',
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * An order belongs to one user (the student who placed it).
     * orders → users (M:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An order can have many order items (the individual food items inside it).
     * orders → order_items (1:M)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * An order can have many payments.
     * orders → payments (1:M)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * An order can have feedback attached to it.
     * orders → feedbacks (1:M)
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}