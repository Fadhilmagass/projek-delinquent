@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Artikel Card --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden p-6 sm:p-8">

                {{-- Judul --}}
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-4">{{ $article->title }}</h1>

                {{-- Tag --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach ($article->tags as $tag)
                        <span
                            class="bg-secondary/20 text-secondary text-xs font-medium px-3 py-1 rounded-full hover:bg-secondary/40 transition duration-200 cursor-default">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                {{-- Info Penulis --}}
                <div class="flex items-center gap-4 mb-6 border-b border-gray-700 pb-6">
                    @if ($article->author)
                        <img class="h-12 w-12 rounded-full object-cover shadow-md"
                            src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                            loading="lazy">
                        <div>
                            <p class="text-md font-semibold text-white">{{ $article->author->name }}</p>
                            <p class="text-sm text-gray-400">Diposting pada {{ $article->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @else
                        {{-- Fallback for deleted or non-existent author --}}
                        <img class="h-12 w-12 rounded-full object-cover shadow-md"
                            src="{{ \Laravolt\Avatar\Facade::create('Guest')->toBase64() }}" alt="Guest Avatar"
                            loading="lazy">
                        <div>
                            <p class="text-md font-semibold text-white">Pengguna Tidak Ditemukan</p>
                            <p class="text-sm text-gray-400">Diposting pada {{ $article->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Gambar Utama --}}
                @if ($article->image)
                    <img class="w-full h-80 sm:h-96 object-cover rounded-xl mb-6 shadow-lg transition duration-300 hover:scale-[1.01]"
                        src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" loading="lazy">
                @endif

                {{-- Isi Artikel --}}
                <div class="prose prose-invert prose-lg max-w-none text-gray-300 leading-relaxed">
                    {!! $article->body !!}
                </div>

                {{-- Voting dan Aksi --}}
                <div
                    class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-10 border-t border-gray-700 pt-6 gap-4">
                    <livewire:votable-buttons :model="$article" />
                    <div class="flex gap-4">
                        @can('update', $article)
                            <a href="{{ route('articles.edit', $article) }}"
                                class="text-sm text-gray-400 hover:text-white transition duration-200 px-3 py-1.5 rounded-md border border-gray-700 hover:border-white">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $article)
                            <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm text-red-500 hover:text-red-400 transition duration-200 px-3 py-1.5 rounded-md border border-red-500 hover:border-red-400">
                                    Hapus
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            {{-- Komentar --}}
            <div class="mt-4 bg-gray-900 border border-gray-800 rounded-2xl shadow-xl p-6 sm:p-8">
                <livewire:show-comments :model="$article" />
            </div>

            {{-- Back to Articles Button --}}
            <div class="mt-8 text-center">
                <a href="{{ route('articles.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-400 hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Artikel
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
