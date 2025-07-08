{{-- File: resources/views/threads/show.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-8">
                {{-- Judul dan Info Author --}}
                <h1 class="text-3xl font-bold text-white">{{ $thread->title }}</h1>
                <div class="flex items-center gap-4 mt-4 border-b border-gray-700 pb-6">
                    <img class="h-12 w-12 rounded-full" src="{{ $thread->author->getAvatarUrl() }}" alt="">
                    <div>
                        <p class="font-semibold text-white">{{ $thread->author->name }}</p>
                        <p class="text-sm text-gray-400">Diposting {{ $thread->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                {{-- Isi Thread --}}
                <div class="prose prose-invert prose-lg mt-6 text-gray-300">
                    {!! $thread->body !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
