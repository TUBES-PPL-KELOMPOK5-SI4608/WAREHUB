<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    protected $fillable = [
        'name',
        'picture_1',
        'picture_2',
        'description',
        'identifier',
        'id_vendor',
    ];
}
