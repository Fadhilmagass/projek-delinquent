<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Kategori Forum</h1>
                    <p class="mt-2 text-sm text-gray-400">Pilih kategori untuk memulai diskusi bersama komunitas.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($categories as $category)
                    <a href="{{ route('forum.categories.show', $category->slug) }}"
                        class="group relative bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-md hover:shadow-lg hover:border-primary hover:bg-gray-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1">

                        {{-- ICON KATEGORI (opsional - bisa ditambahkan dari DB nanti) --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <h2 class="text-lg font-semibold text-white group-hover:text-primary">
                                    {{ $category->name }}
                                </h2>
                            </div>

                            {{-- BADGE THREAD COUNT --}}
                            <span class="bg-primary/20 text-primary text-xs font-semibold px-2 py-1 rounded-full">
                                {{ $category->threads_count }}
                                {{ \Illuminate\Support\Str::plural('Diskusi', $category->threads_count) }}
                            </span>
                        </div>

                        {{-- DESKRIPSI --}}
                        <p class="text-sm text-gray-400 line-clamp-3">{{ $category->description }}</p>

                        {{-- LABEL "Populer" jika threads_count > threshold --}}
                        @if ($category->threads_count > 10)
                            <span
                                class="absolute top-3 right-3 bg-yellow-500 text-xs font-bold text-black px-2 py-0.5 rounded-full">
                                Populer 🔥
                            </span>
                        @endif

                        {{-- CTA --}}
                        <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
                            <span>Lihat diskusi →</span>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500">Belum ada kategori yang dibuat oleh admin.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
