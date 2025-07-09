<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Programming',
            'Web Development',
            'Mobile Development',
            'Game Development',
            'Data Science',
            'Artificial Intelligence',
            'Cybersecurity',
            'DevOps',
            'Cloud Computing',
            'UI/UX Design',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                [
                    'slug' => Str::slug($category),
                    'description' => 'Category for ' . $category . ' related discussions.',
                ]
            );
        }
    }
}
