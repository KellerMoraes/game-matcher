<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('places')->insert(
           [

               [
                   'name' => 'Dalla Favera',
                   'city' => 'Santa Maria',
                   'address' => "BR-287, km 3999 - Camobi",
                   'created_at' => now(),
                   'updated_at' => now(),
                ],
                [
                    'name' => 'Planeta Bola',
                    'city' => 'Santa Maria',
                    'address' => "Alameda Montevideo, 532 - Nossa Sra. das Dores",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]
        );
        //
    }
}