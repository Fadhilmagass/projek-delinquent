<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl p-6 md:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tight">{{ $category->name }}</h1>
                    <p class="mt-1 text-gray-300 max-w-2xl">{{ $category->description }}</p>
                </div>
                <a href="{{ route('threads.create', $category) }}"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg hover:shadow-red-800/30 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Buat Thread</span>
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($threads as $thread)
                    <div
                        class="block bg-gray-800 border border-gray-700 rounded-2xl shadow-lg transition-all duration-300 hover:border-primary/80 hover:shadow-primary/20 hover:shadow-lg hover:-translate-y-1">
                        <a href="{{ route('threads.show', [$category, $thread]) }}"
                            class="flex flex-col sm:flex-row items-start p-5 sm:p-6 gap-5">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover"
                                    src="{{ $thread->author->getAvatarUrl() }}"
                                    alt="{{ $thread->author->name }}'s avatar">
                            </div>

                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-white leading-tight">
                                    {{ $thread->title }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-400">
                                    Dimulai oleh <span
                                        class="font-semibold text-gray-300">{{ $thread->author->name }}</span>
                                    &middot; {{ $thread->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div
                                class="flex-shrink-0 flex sm:flex-col items-end justify-between w-full sm:w-auto mt-4 sm:mt-0 text-right">
                                <div class="flex items-center gap-2 text-sm text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $thread->replies_count }}
                                        {{ \Illuminate\Support\Str::plural('Balasan', $thread->replies_count) }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-400 mt-0 sm:mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{-- Ganti dengan kolom view jika ada, jika tidak ini hanya contoh --}}
                                    <span>{{ $thread->views ?? 0 }}
                                        {{ \Illuminate\Support\Str::plural('Dilihat', $thread->views ?? 0) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center bg-gray-800 border-2 border-dashed border-gray-700 rounded-2xl p-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-white">Belum Ada Diskusi</h3>
                        <p class="mt-1 text-sm text-gray-400">
                            Jadilah yang pertama memulai percakapan di kategori ini.
                        </p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{-- Paginasi akan mengambil gaya dari file kustom --}}
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
