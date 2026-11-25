<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // ✅ Columns that are safe to fill via create() or update()
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    // 🔄 Auto-cast these columns to proper PHP types
    protected $casts = [
        'unit_price' => 'decimal:2',   // Price at the time of order e.g. 45.00
        'subtotal'   => 'decimal:2',   // quantity x unit_price e.g. 135.00
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * An order item belongs to one order.
     * order_items → orders (M:1)
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * An order item belongs to one menu item.
     * order_items → menu_items (M:1)
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}