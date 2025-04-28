<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // App\Models\Inventory.php
    protected $fillable = [
        'name',
        'picture_1',
        'picture_2',
        'description',
        'identifier',
        'id_vendor',
        'created_with',
        'updated_with',
    ];

    // Relasi dengan User untuk created_by
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan User untuk updated_by
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // app/Models/Barang.php
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

}
