<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_package_id',
        'price',
        'number_of_leads',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leadPackage()
    {
        return $this->belongsTo(LeadPackage::class);
    }
}
