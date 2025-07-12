<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-3xl shadow-xl p-6 sm:p-10 transition-all duration-300">

                {{-- Header Profil --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-4 sm:space-y-0">
                    <img class="h-24 w-24 rounded-full object-cover ring-2 ring-primary shadow-md transition hover:scale-105"
                        src="{{ $user->avatar_url }}" alt="{{ $user->name }}">

                    <div class="text-center sm:text-left">
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">{{ $user->name }}</h1>
                        <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                        @if ($user->lokasi)
                            <p class="text-sm text-gray-400 mt-1 flex items-center justify-center sm:justify-start">
                                <i class="fa-solid fa-location-dot mr-1 text-primary"></i>{{ $user->lokasi }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Tentang Saya --}}
                @if ($user->bio)
                    <div class="mt-8 border-t border-gray-700 pt-6">
                        <h2 class="text-xl font-semibold text-white mb-2">Tentang Saya</h2>
                        <p class="text-gray-300 leading-relaxed">{{ $user->bio }}</p>
                    </div>
                @endif

                {{-- Genre Favorit --}}
                @if ($user->genres->isNotEmpty())
                    <div class="mt-8 border-t border-gray-700 pt-6">
                        <h2 class="text-xl font-semibold text-white mb-2">Genre Favorit</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($user->genres as $genre)
                                <span
                                    class="bg-primary-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm hover:bg-primary-700 transition">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Statistik --}}
                <div class="mt-8 border-t border-gray-700 pt-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Statistik</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-gray-300">
                        <div class="p-4 bg-gray-900 rounded-xl shadow hover:bg-gray-800 transition">
                            <p class="text-sm mb-1">Threads</p>
                            <p class="text-2xl font-bold">{{ $user->threads_count }}</p>
                        </div>
                        <div class="p-4 bg-gray-900 rounded-xl shadow hover:bg-gray-800 transition">
                            <p class="text-sm mb-1">Komentar</p>
                            <p class="text-2xl font-bold">{{ $user->comments_count }}</p>
                        </div>
                        <div class="p-4 bg-gray-900 rounded-xl shadow hover:bg-gray-800 transition">
                            <p class="text-sm mb-1">Artikel</p>
                            <p class="text-2xl font-bold">{{ $user->articles_count }}</p>
                        </div>
                    </div>
                </div>

                {{-- Threads Terbaru --}}
                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-white mb-4">Thread Terbaru</h2>
                    @forelse ($threads as $thread)
                        <div
                            class="bg-gray-900 border border-gray-700 rounded-xl p-5 mb-4 hover:bg-gray-800 transition">
                            <h3 class="text-lg sm:text-xl font-semibold text-white">
                                <a href="{{ route('threads.show', $thread->slug) }}"
                                    class="hover:text-primary transition">
                                    {{ $thread->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-400 mt-1">
                                {{ $thread->created_at->diffForHumans() }} di
                                <a href="{{ route('forum.categories.show', $thread->category->slug) }}"
                                    class="hover:text-primary">
                                    {{ $thread->category->name }}
                                </a>
                            </p>
                            <p class="text-gray-300 mt-2 line-clamp-2">{{ $thread->body }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Pengguna ini belum membuat thread.</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $threads->links() }}
                    </div>
                </div>

                {{-- Komentar Terbaru --}}
                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-white mb-4">Komentar Terbaru</h2>
                    @forelse ($comments as $comment)
                        <div
                            class="bg-gray-900 border border-gray-700 rounded-xl p-5 mb-4 hover:bg-gray-800 transition">
                            <p class="text-gray-300">{{ $comment->body }}</p>
                            <p class="text-sm text-gray-400 mt-1">
                                {{ $comment->created_at->diffForHumans() }} pada
                                @if ($comment->commentable_type === 'App\\Models\\Thread')
                                    <a href="{{ route('threads.show', $comment->commentable->slug) }}"
                                        class="hover:text-primary">
                                        Thread: {{ $comment->commentable->title }}
                                    </a>
                                @elseif ($comment->commentable_type === 'App\\Models\\Article')
                                    <a href="{{ route('articles.show', $comment->commentable->slug) }}"
                                        class="hover:text-primary">
                                        Artikel: {{ $comment->commentable->title }}
                                    </a>
                                @endif
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">Pengguna ini belum membuat komentar.</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
