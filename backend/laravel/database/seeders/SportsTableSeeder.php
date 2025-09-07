<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // aqui foi criado o esporte e pegou o id, porque o id do esporte é uma FK do sport variants (e precisa ter a fk)
        $volleyId = DB::table('sports')->insertGetId(
            [
                'name' => 'Vôlei',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $soccerId = DB::table('sports')->insertGetId([
            'name' => 'Futebol',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('sport_variants')->insert(
            [
             'sport_id' => $volleyId,
             'code' => 'volei_6x6',
             'team_size' => 6,
             'outcome_mode' => 'binary',
             'roles_json' => json_encode([
                'positions' => [
                    'Levantador',
                    'Oposto',
                    'Ponteiro',
                    'Central',
                    'Líbero',
                ]
             ]),
             'created_at' => now(),
             'updated_at' => now(),
            ]
        );
        DB::table('sport_variants')->insert(
            [
             'sport_id' => $soccerId,
             'code' => 'society_7x7',
             'team_size' => 7,
             'outcome_mode' => 'binary_with_draw',
             'roles_json' => null,
             'created_at' => now(),
             'updated_at' => now(),
            ]
        );
        //
    }
}
