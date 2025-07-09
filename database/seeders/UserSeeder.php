<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Genre; // <-- Import model Genre

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua genre yang ada untuk dilampirkan ke user
        $genres = Genre::all();

        // Pastikan ada genre di database sebelum melanjutkan
        if ($genres->isEmpty()) {
            $this->command->info('Tidak ada genre di database. Jalankan GenreSeeder terlebih dahulu.');
            return;
        }

        // Membuat 10 user dummy
        User::factory(10)->create()->each(function ($user) use ($genres) {
            // Memberikan data tambahan untuk setiap user
            $user->bio = 'Ini adalah bio singkat dari ' . $user->name . '. Suka musik keras dan gigs.';
            $user->lokasi = 'Jakarta, Indonesia'; // Anda bisa menggunakan Faker untuk lokasi acak
            $user->save();

            // Melampirkan 2 sampai 4 genre acak ke setiap user
            $user->genres()->attach(
                $genres->random(rand(2, 4))->pluck('id')->toArray()
            );
        });

        // Anda juga bisa membuat satu user spesifik untuk login
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // password
                'bio' => 'User khusus untuk testing. Suka semua jenis metal.',
                'lokasi' => 'Bandung, Indonesia',
            ]
        );

        $testUser->genres()->syncWithoutDetaching(
            $genres->random(3)->pluck('id')->toArray()
        );
    }
}
