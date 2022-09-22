<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    public function tahun_pelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function rekenings()
    {
        return $this->belongsToMany(Rekening::class);
    }
    
    public function santris()
    {
        return $this->belongsToMany(Santri::class);
    }

    protected $fillable = [
        'tahun_pelajaran_id',
        'jenjang',
        'ruang',
        'nama'
    ];
}
