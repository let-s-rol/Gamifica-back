<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Badge;

class badgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats_cartas = [
            [
                'name' => 'Responsabilidad',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Cooperación',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Autonomía e Iniciativa',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Gestión Emocional',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => '',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ]
        ];

        foreach ($stats_cartas as $medalla) {
            for ($i = 1; $i <= 5; $i++) {
                $nivel = $i;
                $max_points = 1000 * $nivel;
                $medalla['max_points'] = $max_points;
                $medalla['level'] = $nivel;
                $medalla['img_url'] = $nivel > 0 ? "/assets/medals/{$medalla['name']}$nivel.png" : null;
                Badge::create($medalla);
            }
        }
    }
}
