<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institusi extends Model
{
    use HasFactory;

    public function tahun_pelajarans()
    {
        return $this->hasMany(TahunPelajaran::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    protected $fillable = [
        'nama',
        'group_id',
        'kode',
        'alamat',
        'telepon',
        'website'
    ];
}
