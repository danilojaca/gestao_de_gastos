<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Economia extends Model
{
    use HasFactory;
    protected $fillable = [
        'mes_id',
        'economia',
        'ano',
    ];
}
