<?php

namespace Database\Seeders;

use App\Models\Quinta;
use Illuminate\Database\Seeder;

class QuintaSeeder extends Seeder
{
    public function run(): void
    {
        $quintas = [
            [
                'nombre' => 'Casa Cory',
                'slug' => 'casa-cory',
                'descripcion' => 'Quinta a pie de lago en Tequesquitengo. Registro inicial pendiente de completar y verificar antes de publicarlo.',
                'capacidad' => 16,
                'habitaciones' => 7,
                'camas' => 0,
                'banos' => 0,
                'precio_fin_semana' => 23100.00,
                'anticipo' => null,
                'ubicacion' => 'Tequesquitengo, Morelos',
                'mapa_url' => null,
                'hora_entrada' => '13:00',
                'hora_salida' => '16:00',
                'publicada' => false,
                'destacada' => true,
                'orden' => 1,
            ],
            [
                'nombre' => 'Casa Luna',
                'slug' => 'casa-luna',
                'descripcion' => 'Quinta a pie de lago en Tequesquitengo. Registro inicial pendiente de completar y verificar antes de publicarlo.',
                'capacidad' => 16,
                'habitaciones' => 7,
                'camas' => 0,
                'banos' => 0,
                'precio_fin_semana' => 23100.00,
                'anticipo' => null,
                'ubicacion' => 'Tequesquitengo, Morelos',
                'mapa_url' => null,
                'hora_entrada' => '13:00',
                'hora_salida' => '16:00',
                'publicada' => false,
                'destacada' => false,
                'orden' => 2,
            ],
        ];

        foreach ($quintas as $quinta) {
            Quinta::updateOrCreate(
                ['slug' => $quinta['slug']],
                $quinta,
            );
        }
    }
}
