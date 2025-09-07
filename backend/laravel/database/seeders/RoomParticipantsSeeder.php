<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorId = DB::table('users')->insertGetId(
               [
                   'name' => 'Urutu',
                   'email' => 'urutu567@example.com',
                   'password' => bcrypt("123456"),
                   'created_at' => now(),
                   'updated_at' => now(),
                ],
            );
            $randomDude1 = DB::table('users')->insertGetId(
                [
                    'name' => 'Fulano de Tal',
                    'email' => 'fulano123@example.com',
                    'password' => bcrypt("123456789"),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
            $randomDude2 = DB::table('users')->insertGetId(
                [
                    'name' => 'Ciclano de Tal',
                    'email' => 'ciclano234@example.com',
                    'password' => bcrypt("abcdefgh"),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
            
            $placeId = DB::table('places')->where('name', 'Dalla Favera')->value('id');
            $variantId = DB::table('sport_variants')->where('code', 'volei_6x6')->value('id');
            $roomId = DB::table('rooms')->insertGetId(
                [
                    'title' => 'Jogo hoje, só adulto',
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
                    ]
                );
                DB::table('room_participants')->insert(
                    [
                        [
                        'room_id' => $roomId,
                        'user_id' => $creatorId,
                        'permission' => 'owner',
                        'state' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'room_id' => $roomId,
                        'user_id' => $randomDude1,
                        'permission' => 'admin',
                        'state' => 'approved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'room_id' => $roomId,
                        'user_id' => $randomDude2,
                        'permission' => 'player',
                        'state' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
                );
    }
}
