<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function rekenings()
    {
        return $this->belongsToMany(Rekening::class);
    }

    protected $fillable = [
        'nama',
        'harga'
    ];
}
