<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retur extends Model
{
    use HasFactory;

    protected $table = 'returs';

    protected $fillable = [
        'name',
        'picture_1',
        'picture_2',
        'description',
        'status',
        'id_vendor',
        'created_with',
        'updated_with',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }
}
