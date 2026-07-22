<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quinta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'capacidad',
        'habitaciones',
        'camas',
        'banos',
        'precio_fin_semana',
        'anticipo',
        'ubicacion',
        'mapa_url',
        'hora_entrada',
        'hora_salida',
        'publicada',
        'destacada',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'banos' => 'decimal:1',
            'precio_fin_semana' => 'decimal:2',
            'anticipo' => 'decimal:2',
            'publicada' => 'boolean',
            'destacada' => 'boolean',
            'orden' => 'integer',
        ];
    }
}