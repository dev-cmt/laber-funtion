<?php
// ServiceRequestProduct.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequestProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_id',
        'product_id',
        'quantity',
        'notes',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}