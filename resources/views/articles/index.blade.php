{{-- File: resources/views/articles/index.blade.php (Ditingkatkan) --}}
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    {{-- Latar belakang gradien halus untuk efek visual --}}
    <div
        class="absolute inset-0 -z-10 h-full w-full bg-slate-950 bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:16px_16px]">
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header and Search --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-10 gap-4">
                <h1 class="text-4xl font-bold text-white tracking-tight">Artikel & Blog</h1>
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    {{-- Pencarian --}}
                    <form action="{{ route('articles.index') }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="search" placeholder="Cari artikel..."
                            value="{{ request('search') }}"
                            class="w-full rounded-lg border-2 border-gray-700 bg-gray-900/80 backdrop-blur-sm px-4 py-2.5 text-white placeholder-gray-400 shadow-sm focus:border-primary focus:ring-2 focus:ring-primary/50 transition duration-300 ease-in-out pl-10">
                        <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                    {{-- Tombol Tulis Artikel --}}
                    @can('create', App\Models\Article::class)
                        <a href="{{ route('articles.create') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-800/20 hover:bg-red-700 transition-all duration-300 hover:scale-105 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tulis Artikel</span>
                        </a>
                    @endcan
                </div>
            </div>

            {{-- Daftar Artikel --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($articles as $article)
                    {{-- Kartu Artikel yang Interaktif --}}
                    <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-primary/20 transition-all duration-300 group flex flex-col cursor-pointer hover:border-primary/50"
                        onclick="window.location='{{ route('articles.show', $article) }}'">

                        {{-- Gambar --}}
                        <div class="overflow-hidden">
                            <img class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out"
                                src="{{ $article->image_url ?? 'https://placehold.co/600x400/1e293b/E2E8F0?text=No+Image' }}"
                                alt="Gambar sampul untuk {{ $article->title }}">
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Tags Fungsional --}}
                            <div class="mb-3 flex flex-wrap gap-2">
                                @foreach ($article->tags->take(3) as $tag)
                                    <a href="{{ route('articles.index', ['tag' => $tag->name]) }}"
                                        class="relative z-10 inline-block bg-gray-700/80 text-gray-300 text-xs font-medium px-2.5 py-1 rounded-full hover:bg-primary/80 hover:text-white transition duration-200">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>

                            {{-- Judul Artikel Utama --}}
                            <h2
                                class="text-xl font-bold text-white mb-3 group-hover:text-primary transition-colors duration-300">
                                {{-- Judul menjadi link utama untuk SEO & aksesibilitas --}}
                                <a href="{{ route('articles.show', $article) }}"
                                    class="relative z-10">{{ $article->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-400 line-clamp-3 flex-grow">{{ $article->excerpt }}</p>

                            {{-- Info Penulis & Tanggal --}}
                            <div class="mt-5 pt-4 border-t border-gray-800 flex items-center gap-3">
                                @if ($article->author)
                                    <a href="{{ route('users.show', $article->author->slug) }}" class="flex items-center gap-3 group">
                                        <img class="w-10 h-10 rounded-full object-cover transition-transform duration-300 group-hover:scale-110"
                                            src="{{ $article->author->avatar_url }}"
                                            alt="Avatar {{ $article->author->name }}">
                                        <div>
                                            <p class="text-sm font-semibold text-white group-hover:text-primary transition-colors duration-300">{{ $article->author->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </a>
                                @else
                                    {{-- Fallback for deleted or non-existent author --}}
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full object-cover"
                                            src="{{ \Laravolt\Avatar\Facade::create('Guest')->toBase64() }}"
                                            alt="Guest Avatar">
                                        <div>
                                            <p class="text-sm font-semibold text-white">Pengguna Tidak Ditemukan</p>
                                            <p class="text-xs text-gray-500">{{ $article->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Tampilan Saat Artikel Kosong --}}
                    <div
                        class="col-span-full text-center py-20 px-6 bg-gray-900/80 backdrop-blur-sm border border-dashed border-gray-700 rounded-xl shadow-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-white">Tidak Ada Artikel</h3>
                        <p class="mt-1 text-sm text-gray-400">
                            @if (request('search'))
                                Tidak ditemukan artikel dengan kata kunci "{{ request('search') }}".
                            @else
                                Belum ada artikel yang dipublikasikan.
                            @endif
                        </p>
                        @can('create', App\Models\Article::class)
                            <div class="mt-6">
                                <a href="{{ route('articles.create') }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-red-800/20 hover:bg-red-700 transition-all duration-300 hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tulis Artikel Pertama Anda
                                </a>
                            </div>
                        @endcan
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($articles->hasPages())
                <div class="mt-12">
                    {{ $articles->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
