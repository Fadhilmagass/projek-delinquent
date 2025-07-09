<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'bio' => 'Saya adalah admin situs komunitas ini.',
                'lokasi' => 'Surabaya, Indonesia',
            ]
        );

        $admin->genres()->syncWithoutDetaching(
            $genres->random(3)->pluck('id')->toArray()
        );

        // Assign 'admin' role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        $this->command->info('Admin berhasil dibuat/diupdate dengan email: admin@example.com dan password: admin123');
    }
}
