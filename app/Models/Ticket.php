<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'ticket_code',
        'qr_code',
        'payment_reference',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
