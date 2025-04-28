<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendor extends Model
{
    // app/Models/Vendor.php
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

}
