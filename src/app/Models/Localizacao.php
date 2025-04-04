<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'explorador_id', 
        'latitude',
        'longitude',
    ];

    protected $table = 'localizacoes';
}
