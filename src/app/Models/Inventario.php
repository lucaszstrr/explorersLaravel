<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 
        'valorItem',
        'latitude',
        'longitude',
    ];

    public function explorador(){
        return $this->belongsTo(Explorador::class);
    }
}
