<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stock_out extends Model
{
    protected $fillable = ['date', 'status', 'id_inventory', 'created_with', 'updated_with'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'id_inventory');
    }
}
