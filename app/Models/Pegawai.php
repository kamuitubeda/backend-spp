<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    protected $fillable = [
        'nama',
        'jabatan',
        'aktif'
    ];
}
