<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white">{{ $category->name }}</h1>
                        <p class="text-gray-400 mt-1">{{ $category->description }}</p>
                    </div>
                    <a href="{{ route('forum.threads.create') }}" class="px-4 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-red-700 transition">
                        Buat Thread
                    </a>
                </div>
                <div class="text-sm text-gray-400 mt-2">
                    <a href="{{ route('forum.index') }}" class="text-primary hover:underline">Forum</a> &raquo; {{ $category->name }}
                </div>
            </div>

            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl overflow-hidden">
                <div class="divide-y divide-gray-700">
                    @forelse ($threads as $thread)
                        <div class="p-6 flex justify-between items-center hover:bg-gray-800 transition">
                            <div>
                                <a href="{{ route('threads.show', $thread) }}" class="text-lg font-semibold text-white hover:text-primary transition">{{ $thread->title }}</a>
                                <p class="text-sm text-gray-400 mt-1">
                                    Oleh <a href="{{ route('users.show', $thread->author->slug) }}" class="text-primary hover:underline">{{ $thread->author->name }}</a>, {{ $thread->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-white">{{ $thread->comments()->count() }} Balasan</p>
                                {{-- <p class="text-gray-400 text-sm">{{ $thread->votes_count }} Votes</p> --}}
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <p>Belum ada thread di kategori ini. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>