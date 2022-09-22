<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    public function rekenings()
    {
        return $this->belongsToMany(Rekenings::class);
    }

    public function santris()
    {
        return $this->belongsToMany(Santri::class);
    }

    protected $fillable = [
        'rekening_id',
        'santri_id',
        'lunas',
        'tanggal_pelunasan',
        'pencatat_pelunasan_id',
        'tanggal_pengeluaran',
        'pencatat_pengeluaran_id',
        'aktif'
    ];
}
