<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    // ✅ Columns that are safe to fill via create() or update()
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'stock',
    ];

    // 🔄 Auto-cast these columns to proper PHP types
    protected $casts = [
        'price'        => 'decimal:2',   // Always 2 decimal places e.g. 45.00
        'is_available' => 'boolean',     // Converts 1/0 to true/false
        'stock'        => 'integer',
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * A menu item can appear in many order items.
     * menu_items → order_items (1:M)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * A menu item can have many feedback entries.
     * menu_items → feedbacks (1:M)
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}