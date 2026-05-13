<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'client_name',
        'client_no',
        'client_phone',
        'client_company',
        'client_address',
        'client_email',
        'tenant_name',
        'tenant_no',
        'landlord_name',
        'landlord_no',
        'landlord_address',
        'landlord_email',
        'gas_cert_expiry',
        'electric_cert_expiry',
        'fire_alarm_expiry',
        'emergency_light_expiry',
        'epc_expiry',
        'pat_testing_expiry',
    ];

    public function managedJobs()
    {
        return $this->hasMany(ManagedJob::class);
    }

    public function teamLogs()
    {
        return $this->hasMany(TeamLog::class, 'site_id');
    }

    public function dailyFinances()
    {
        return $this->hasMany(DailyFinance::class, 'site_id');
    }
}
