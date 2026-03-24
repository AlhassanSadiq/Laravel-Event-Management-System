<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount_amount', 'type', 'is_active', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid()
    {
        if ($this->expires_at) {
            // Allow the coupon to be valid until the VERY END of the selected expiry date
            if ($this->expires_at->endOfDay() < now()) {
                return false;
            }
        }
        
        return true;
    }
}
