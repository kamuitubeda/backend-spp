<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory;
    
    public function institusi()
    {
        return $this->belongsTo(Institusi::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    protected $fillable = [
        'institusi_id',
        'nama'
    ];
}
