<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagedJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'scheduled_at',
        'job_details',
        'agreed_price',
        'vat',
        'total_price',
        'cash_payment_received',
        'acc_payment_received',
        'status',
        'who_attended',
        'tools_needed',
        'materials_needed',
        'media_links',
    ];

    protected $casts = [
        'media_links' => 'array',
        'scheduled_at' => 'datetime',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
