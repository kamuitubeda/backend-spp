<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianRekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekening_id',
        'item_id'
    ];
}
