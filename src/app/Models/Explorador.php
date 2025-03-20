<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explorador extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'idade',
        'latitude',
        'longitude',
    ];

    protected $table = "exploradores";

    public function inventario(){
        return $this->hasMany(Inventario::class);
    }
    
}
