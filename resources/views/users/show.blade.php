<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-br from-gray-900 to-gray-800 text-white rounded-3xl shadow-lg overflow-hidden p-6 sm:p-10">

                {{-- Info Pengguna (Livewire Component) --}}
                @livewire('user-profile-info', ['user' => $user])

                {{-- Threads --}}
                <div class="mt-10 pt-8 border-t border-gray-700">
                    <h4 class="text-xl font-bold mb-4">Threads oleh {{ $user->name }}</h4>
                    @forelse ($threads as $thread)
                        <div
                            class="bg-gray-900 border border-gray-700 rounded-xl p-5 mb-4 hover:bg-gray-800 transition">
                            <h5 class="text-lg font-semibold">
                                <a href="{{ route('threads.show', $thread->slug) }}"
                                    class="hover:text-primary transition">
                                    {{ $thread->title }}
                                </a>
                            </h5>
                            <p class="text-sm text-gray-400 mt-1">
                                {{ $thread->created_at->translatedFormat('d M Y H:i') }}
                            </p>
                            <p class="mt-2 text-gray-300 line-clamp-3">
                                {{ Str::limit($thread->body, 200) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500 py-4 px-5 bg-gray-900 border border-gray-700 rounded-xl">Pengguna ini belum membuat thread.</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $threads->links() }}
                    </div>
                </div>

                {{-- Artikel --}}
                <div class="mt-10 pt-8 border-t border-gray-700">
                    <h4 class="text-xl font-bold mb-4">Artikel oleh {{ $user->name }}</h4>
                    @forelse ($articles as $article)
                        <div
                            class="bg-gray-900 border border-gray-700 rounded-xl p-5 mb-4 hover:bg-gray-800 transition">
                            <h5 class="text-lg font-semibold">
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="hover:text-primary transition">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            <p class="text-sm text-gray-400 mt-1">
                                {{ $article->created_at->translatedFormat('d M Y H:i') }}
                            </p>
                            <p class="mt-2 text-gray-300 line-clamp-3">
                                {{ Str::limit($article->body, 200) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500 py-4 px-5 bg-gray-900 border border-gray-700 rounded-xl">Pengguna ini belum membuat artikel.</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
