<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    protected $fillable = [
        'kelas_id',
        'nomor_induk',
        'nama',
        'alamat',
        'telepon',
        'nama_wali',
        'aktif'
    ];
}
