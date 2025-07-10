{{-- File: resources/views/articles/partials/form.blade.php (Ditingkatkan) --}}
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="space-y-8">
    {{-- Judul --}}
    <div>
        <label for="title" class="block text-sm font-medium leading-6 text-gray-300">Judul</label>
        <div class="mt-2">
            <input type="text" name="title" id="title"
                class="block w-full rounded-md border-0 bg-gray-800/50 py-2.5 text-white shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary transition duration-150 ease-in-out sm:text-sm sm:leading-6"
                required value="{{ old('title', $article->title ?? '') }}" placeholder="Apa judul artikel Anda?" maxlength="255">
            <p class="mt-2 text-xs text-gray-400 text-right"><span id="title-char-count">0</span>/255 karakter</p>
            @error('title')
                <p class="mt-2 text-sm text-red-500 animate-pulse">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Kutipan Singkat (Excerpt) --}}
    <div>
        <label for="excerpt" class="block text-sm font-medium leading-6 text-gray-300">Kutipan Singkat
            (Excerpt)</label>
        <div class="mt-2">
            <textarea id="excerpt" name="excerpt" rows="3"
                class="block w-full rounded-md border-0 bg-gray-800/50 py-2.5 text-white shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-primary transition duration-150 ease-in-out sm:text-sm sm:leading-6"
                required placeholder="Tulis deskripsi singkat yang menarik..." maxlength="300">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            <p class="mt-2 text-xs text-gray-400 text-right"><span id="excerpt-char-count">0</span>/300 karakter</p>
            @error('excerpt')
                <p class="mt-2 text-sm text-red-500 animate-pulse">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Isi Artikel (dengan EasyMDE) --}}
    <div>
        <label for="body" class="block text-sm font-medium leading-6 text-gray-300">Isi Artikel</label>
        <div class="mt-2">
            <textarea id="body" name="body" rows="12">{{ old('body', $article->body ?? '') }}</textarea>
            @error('body')
                <p class="mt-2 text-sm text-red-500 animate-pulse">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Tags (dengan Tagify) --}}
    <div>
        <label for="tags" class="block text-sm font-medium leading-6 text-gray-300">Tags</label>
        <div class="mt-2">
            <input type="text" name="tags" id="tags" class="block w-full" required
                value="{{ old('tags', $article->tags->pluck('name')->implode(', ') ?? '') }}"
                placeholder="metal, review-album, konser">
            @error('tags')
                <p class="mt-2 text-sm text-red-500 animate-pulse">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Gambar Artikel dengan Pratinjau --}}
    <div>
        <label for="image" class="block text-sm font-medium leading-6 text-gray-300">Gambar Artikel
            (Opsional)</label>
        <div class="mt-2 flex items-center gap-x-4">
            {{-- Pratinjau Gambar --}}
            <img id="image-preview"
                src="{{ $article->image ? Storage::url($article->image) : 'https://placehold.co/200x120/334155/E2E8F0?text=Pilih+Gambar' }}"
                alt="Pratinjau Gambar" class="h-24 w-40 rounded-md object-cover bg-gray-700">

            <div>
                <input type="file" name="image" id="image" accept="image/*" class="hidden"
                    onchange="previewImage(event)">
                <label for="image"
                    class="cursor-pointer rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/20">
                    Ganti Gambar
                </label>
                @if ($article->image)
                    <button type="button" id="remove-image-button"
                        class="ml-3 text-sm font-semibold text-red-400 hover:text-red-300">
                        Hapus Gambar
                    </button>
                @endif
                <input type="hidden" name="remove_image" id="remove_image" value="0">
                <p class="mt-2 text-xs text-gray-400">PNG, JPG, GIF hingga 2MB.</p>
            </div>
        </div>
        @error('image')
            <p class="mt-2 text-sm text-red-500 animate-pulse">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Tombol Aksi --}}
<div class="mt-10 flex items-center justify-end gap-x-6 border-t border-gray-700 pt-6">
    <a href="{{ route('articles.index') }}"
        class="text-sm font-semibold leading-6 text-gray-300 hover:text-white transition">Batal</a>
    <button type="submit"
        class="rounded-md bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition duration-150 ease-in-out">
        {{ $article->exists ? 'Perbarui Artikel' : 'Publikasikan' }}
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Inisialisasi EasyMDE untuk editor Markdown
            const easyMDE = new EasyMDE({
                element: document.getElementById('body'),
                spellChecker: false, // Matikan jika tidak perlu
                placeholder: "Mulai tulis mahakarya Anda di sini...",
                status: ["lines", "words"], // Hanya tampilkan status baris dan kata
                toolbar: [
                    "bold", "italic", "heading", "|",
                    "quote", "unordered-list", "ordered-list", "|",
                    "link", "image", "|",
                    "preview", "side-by-side", "fullscreen", "|",
                    "guide"
                ],
                // Styling agar lebih gelap
                minHeight: "300px",
                theme: "dark" // improvisasi agar tema lebih menyatu
            });

            // 2. Inisialisasi Tagify untuk input tags
            const tagsInput = document.querySelector('input[name="tags"]');
            new Tagify(tagsInput, {
                originalInputValueFormat: (d) => d.map(item => item.value).join(',')
                // Opsi tambahan jika diperlukan, misalnya whitelist atau dropdown
            });

            // 3. Logika Penghitung Karakter
            const titleInput = document.getElementById('title');
            const titleCharCount = document.getElementById('title-char-count');
            const excerptInput = document.getElementById('excerpt');
            const excerptCharCount = document.getElementById('excerpt-char-count');

            function updateCharCount(inputElement, countElement) {
                countElement.textContent = inputElement.value.length;
            }

            // Inisialisasi awal
            updateCharCount(titleInput, titleCharCount);
            updateCharCount(excerptInput, excerptCharCount);

            // Event listener untuk update saat mengetik
            titleInput.addEventListener('input', () => updateCharCount(titleInput, titleCharCount));
            excerptInput.addEventListener('input', () => updateCharCount(excerptInput, excerptCharCount));

            // 4. Logika untuk tombol Hapus Gambar
            const removeImageButton = document.getElementById('remove-image-button');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');
            const removeImageHiddenInput = document.getElementById('remove_image');

            if (removeImageButton) {
                removeImageButton.addEventListener('click', function() {
                    imagePreview.src = 'https://placehold.co/200x120/334155/E2E8F0?text=Pilih+Gambar';
                    imageInput.value = ''; // Clear the file input
                    removeImageHiddenInput.value = '1'; // Set flag to remove image on save
                    removeImageButton.style.display = 'none'; // Hide the button
                });
            }

        });

        // 5. Fungsi untuk Pratinjau Gambar
        function previewImage(event) {
            const reader = new FileReader();
            const output = document.getElementById('image-preview');
            const removeImageButton = document.getElementById('remove-image-button');
            const removeImageInput = document.getElementById('remove_image');

            reader.onload = function() {
                output.src = reader.result;
                if (removeImageButton) {
                    removeImageButton.style.display = 'inline-block'; // Show remove button if image is selected
                }
                if (removeImageInput) {
                    removeImageInput.value = '0'; // Reset remove flag
                }
            };

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {
                // If no file is selected (e.g., user cancels file dialog)
                // Do nothing, maintain current state or previous image
            }
        }
    </script>
@endpush
