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
                'name' => 'Cooperacion',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Iniciativa',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Emocional',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ],
            [
                'name' => 'Pensamiento',
                'level' => 0,
                'max_points' => 1000,
                'img_url' => null
            ]
        ];

        $points_per_level = [0, 1000, 2000, 4000, 7000, 10000]; // nivel 0 al 5

        foreach ($stats_cartas as $medalla) {
            for ($i = 0; $i <= 5; $i++) {
                $nivel = $i;
                $max_points = $points_per_level[$nivel];
                $medalla['max_points'] = $max_points;
                $medalla['level'] = $nivel;
                $medalla['img_url'] = $nivel > 0 ? "/assets/medals/{$medalla['name']}$nivel.png" : null;
                Badge::create($medalla);
            }
        }
    }
}
