<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    {{-- Tombol Vote untuk Thread --}}
                    <div class="flex-shrink-0 mx-auto sm:mx-0">
                        <livewire:votable-buttons :model="$thread" :wire:key="'thread-vote-'.$thread->id" />
                    </div>

                    <div class="flex-1">
                        {{-- Judul dan Info Author --}}
                        <h1 class="text-3xl font-bold text-white">{{ $thread->title }}</h1>
                        <div class="flex items-center gap-4 mt-2">
                            <img class="h-8 w-8 rounded-full" src="{{ $thread->author->getAvatarUrl() }}" alt="">
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $thread->author->name }}</p>
                                <p class="text-xs text-gray-400">Diposting {{ $thread->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Isi Thread --}}
                <div class="prose prose-invert prose-lg mt-6 text-gray-300 border-t border-gray-700 pt-6">
                    {!! $thread->body !!}
                </div>
            </div>

            {{-- Komponen Komentar --}}
            <div class="mt-8">
                <livewire:show-comments :thread="$thread" :wire:key="'comments-for-thread-'.$thread->id" />
            </div>
        </div>
    </div>
</x-app-layout>
