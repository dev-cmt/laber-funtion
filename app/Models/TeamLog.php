<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_name',
        'date',
        'site_id',
        'shift_type',
        'daily_pay',
        'is_paid',
        'receipt_links',
    ];

    protected $casts = [
        'receipt_links' => 'array',
        'is_paid' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'site_id');
    }
}
