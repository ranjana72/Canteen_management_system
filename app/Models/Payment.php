<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // ✅ Columns that are safe to fill via create() or update()
    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'method',
        'status',
        'transaction_id',
        'transaction_uuid',
        'paid_at',
    ];

    // 🔄 Auto-cast these columns to proper PHP types
    protected $casts = [
        'amount'  => 'decimal:2',   // e.g. 150.00
        'paid_at' => 'datetime',    // Converts DB timestamp to Carbon date object
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * A payment belongs to one order.
     * payments → orders (M:1)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * A payment belongs to one user (the student who paid).
     * payments → users (M:1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}