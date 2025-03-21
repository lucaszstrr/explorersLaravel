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
        'explorador_id',
        'latitude',
        'longitude',
    ];

    protected $table = "inventario";

    public function explorador(){
        return $this->belongsTo(Explorador::class);
    }
}
