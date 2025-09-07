<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorId = DB::table('users')->insertGetId(
               [
                   'name' => 'Urutu',
                   'email' => 'urutu234@example.com',
                   'password' => bcrypt("123456"),
                   'created_at' => now(),
                   'updated_at' => now(),
                ],
            );
            $placeId = DB::table('places')->where('name', 'Dalla Favera')->value('id');
            $variantId = DB::table('sport_variants')->where('code', 'volei_6x6')->value('id');
            DB::table('rooms')->insert(
                [

                    [
                        'title' => 'Apenas pessoas altas',
                        'variant_id' => $variantId,
                        'place_id' => $placeId,
                        'creator_id' => $creatorId,
                        'starts_at' => now()->addDays(3),
                        'ends_at' => null,
                        'visibility' => 'open',
                        'notes' => 'Já temos bola.',
                        'status' => 'open',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title' => 'Jogo de graça, venha!',
                        'variant_id' => $variantId,
                        'place_id' => $placeId,
                        'creator_id' => $creatorId,
                        'starts_at' => now(),
                        'ends_at' => null,
                        'visibility' => 'open',
                        'notes' => 'Já temos bola.',
                        'status' => 'open',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
                    );
        //
    }
}