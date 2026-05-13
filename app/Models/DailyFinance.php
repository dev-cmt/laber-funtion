<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyFinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_type',
        'site_id',
        'date',
        'cash_out',
        'cash_in',
        'cash_refund',
        'acc_out',
        'acc_in',
        'acc_refund',
        'invoice_references',
    ];

    protected $casts = [
        'invoice_references' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'site_id');
    }
}
