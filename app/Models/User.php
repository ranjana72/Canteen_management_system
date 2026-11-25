<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Columns that are safe to fill via create() or update()
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    // 🔒 Columns that are NEVER sent out (e.g. in API responses)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔄 Auto-cast these columns to proper PHP types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',        // Laravel auto-hashes on save
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * A user can place many orders.
     * users → orders (1:M)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * A user can make many payments.
     * users → payments (1:M)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * A user (student) can leave many feedback entries.
     * users → feedbacks (1:M)
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}