<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = User::first() ?? User::factory()->create();

        $articles = [
            [
                'title' => 'Keganasan Lorna Shore di Album "Pain Remains"',
                'excerpt' => 'Album ini adalah manifestasi dari keputusasaan dan keindahan yang dibalut dalam orkestra kemarahan.',
                'body' => <<<MARKDOWN
**Lorna Shore** kembali mengoyak batasan deathcore dengan *Pain Remains*. Album ini tidak hanya brutal, tapi juga menyentuh sisi emosional lewat orkestra dan harmoni.

Track seperti *"Sun//Eater"* dan *"Cursed To Die"* menampilkan transisi antara breakdown dan bagian simfonik yang megah. Sebuah karya yang wajib didengar oleh pecinta musik ekstrem modern.
MARKDOWN,
                'image' => null,
            ],
            [
                'title' => 'Knocked Loose dan Teror Panggung yang Mendidih',
                'excerpt' => 'Konser mereka seperti ritual: penuh energi, chaos, dan sing-along yang brutal.',
                'body' => <<<MARKDOWN
**Knocked Loose** bukan hanya band hardcore biasa. Live performance mereka adalah pengalaman spiritual bagi banyak penonton.

Dengan setlist penuh seperti *"Counting Worms"*, *"Mistakes Like Fractures"*, dan *"God Knows"*, pit pun menjadi ladang pelampiasan emosi.
MARKDOWN,
                'image' => null,
            ],
            [
                'title' => '5 Rekomendasi Band Deathcore untuk Pendatang Baru',
                'excerpt' => 'Jika kamu baru menyelami deathcore, berikut 5 band wajib yang bisa jadi gerbangmu menuju gelapnya dunia breakdown.',
                'body' => <<<MARKDOWN
1. **Lorna Shore** – Penuh orkestra, atmosfir, dan growl brutal.
2. **Chelsea Grin** – Gabungan klasik dan modern dalam satu kemarahan.
3. **Slaughter to Prevail** – Breakdown tiada henti.
4. **Thy Art Is Murder** – Vokal neraka dan riff yang kejam.
5. **Brand of Sacrifice** – Sci-fi meets chaos.

Jangan lupa pakai headphone yang kuat. Dunia ini tidak ramah untuk pendengar santai.
MARKDOWN,
                'image' => null,
            ],
        ];

        foreach ($articles as $data) {
            Article::create([
                'user_id' => $author->id,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'body' => $data['body'],
                'image' => $data['image'],
            ]);
        }
    }
}
