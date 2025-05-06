<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'identifier',
        'id_vendor',
        'picture_1',
        'picture_2',
        'created_with',
        'status',
        'updated_with'
    ];

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }
}
