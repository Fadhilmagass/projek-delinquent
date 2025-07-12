<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-white">Forum Kategori</h1>
                <a href="{{ route('forum.threads.create') }}" class="px-4 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-red-700 transition">
                    Buat Thread Baru
                </a>
            </div>

            <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    @forelse ($categories as $category)
                        <div class="p-6 border-b border-gray-700 md:border-r">
                            <a href="{{ route('forum.categories.show', $category->slug) }}" class="block">
                                <h2 class="text-xl font-semibold text-primary hover:underline">{{ $category->name }}</h2>
                                <p class="text-gray-400 mt-2">{{ $category->description }}</p>
                            </a>
                            <div class="text-sm text-gray-500 mt-4">
                                <span>{{ $category->threads_count }} threads</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 col-span-full">
                            <p>Belum ada kategori yang dibuat.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
