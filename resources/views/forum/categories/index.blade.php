<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-2xl font-bold leading-6 text-gray-100">Kategori Forum</h1>
                        <p class="mt-2 text-sm text-gray-400">Pilih kategori untuk memulai diskusi.</p>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($categories as $category)
                            {{-- PERBAIKAN: Menggunakan route() untuk link dan menampilkan threads_count --}}
                            <a href="{{ route('threads.index', $category) }}"
                                class="block p-6 bg-gray-800 border border-gray-700 rounded-2xl shadow-lg hover:bg-gray-700 hover:border-primary transition duration-300 ease-in-out transform hover:-translate-y-1">
                                <h2 class="text-xl font-bold text-white">{{ $category->name }}</h2>
                                <p class="mt-2 text-sm text-gray-400">{{ $category->description }}</p>
                                <div class="mt-4 text-sm text-gray-500">
                                    {{-- PERBAIKAN: Menggunakan namespace lengkap untuk Str --}}
                                    <span>{{ $category->threads_count }}
                                        {{ \Illuminate\Support\Str::plural('Diskusi', $category->threads_count) }}</span>
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
        </div>
    </div>
</x-app-layout>
