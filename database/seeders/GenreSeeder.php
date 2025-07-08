<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Heavy Metal',
            'Thrash Metal',
            'Death Metal',
            'Black Metal',
            'Doom Metal',
            'Power Metal',
            'Metalcore',
            'Deathcore',
            'Hardcore Punk',
            'Grindcore',
            'Post-Hardcore',
            'Slam'
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
                'slug' => Str::slug($genre)
            ]);
        }
    }
}
