<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    // Nama tabel (optional, kalau nama tabelnya gak sesuai konvensi Laravel)
    protected $table = 'vendors';
    public $timestamps = false;

    // Kolom-kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'name',
        'contact',
    ];
}
