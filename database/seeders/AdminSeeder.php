<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            $this->command->info('Genre tidak ditemukan. Jalankan GenreSeeder terlebih dahulu.');
            return;
        }

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'bio' => 'Saya adalah admin situs komunitas ini.',
            'lokasi' => 'Surabaya, Indonesia',
        ]);

        $admin->genres()->attach(
            $genres->random(3)->pluck('id')->toArray()
        );

        $this->command->info('Admin berhasil dibuat dengan email: admin@example.com dan password: admin123');
    }
}
