<x-app-layout>
    <div class="py-12 md:py-20" x-data="{
        activeTab: 'profile',
        observe() {
            let observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-4')
                    }
                })
            }, {
                threshold: 0.1
            })
            document.querySelectorAll('.activity-item').forEach(el => {
                observer.observe(el)
            })
        }
    }" x-init="observe()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Kartu Profil Utama --}}
            <div
                class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl shadow-2xl shadow-black/20 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                        {{-- Avatar --}}
                        <div class="flex-shrink-0 relative group">
                            <img class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-gray-600 shadow-lg transition-transform duration-300 group-hover:scale-105"
                                src="{{ auth()->user()->getAvatarUrl() }}" alt="{{ auth()->user()->name }}'s avatar">
                            <span
                                class="absolute bottom-2 right-2 bg-green-500 rounded-full h-5 w-5 border-2 border-gray-800"></span>
                        </div>

                        {{-- Info Pengguna & Statistik --}}
                        <div class="flex-grow text-center md:text-left">
                            <h1 class="text-3xl font-bold text-white break-words">
                                {{ auth()->user()->name }}
                            </h1>

                            @if (auth()->user()->lokasi)
                                <div class="flex items-center justify-center md:justify-start gap-2 text-gray-400 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">{{ auth()->user()->lokasi }}</span>
                                </div>
                            @endif

                            {{-- Panel Statistik --}}
                            <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-4 text-center">
                                <div class="px-4 py-2 bg-gray-700/50 rounded-lg">
                                    <p class="text-2xl font-bold text-primary">{{ auth()->user()->threads_count }}</p>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Threads</p>
                                </div>
                                <div class="px-4 py-2 bg-gray-700/50 rounded-lg">
                                    <p class="text-2xl font-bold text-primary">{{ auth()->user()->comments_count }}</p>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Komentar</p>
                                </div>
                                <div class="px-4 py-2 bg-gray-700/50 rounded-lg">
                                    <p class="text-2xl font-bold text-primary">
                                        {{ auth()->user()->created_at->diffForHumans(null, true) }}</p>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Bergabung</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Edit --}}
                        <div class="flex-shrink-0 mt-4 md:mt-0">
                            <a href="{{ route('profile.edit') }}"
                                class="w-full md:w-auto text-center bg-primary hover:bg-red-700 text-white font-bold py-2 px-5 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg hover:shadow-red-800/30">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Navigasi Tab --}}
                <div class="border-t border-gray-700/50 px-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'profile'"
                            :class="{ 'border-primary text-primary': activeTab === 'profile', 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-500': activeTab !== 'profile' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            Profil
                        </button>
                        <button @click="activeTab = 'activity'"
                            :class="{ 'border-primary text-primary': activeTab === 'activity', 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-500': activeTab !== 'activity' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                            Aktivitas Terbaru
                        </button>
                    </nav>
                </div>
            </div>

            {{-- Konten Tab --}}
            <div class="mt-8">
                {{-- Tab Profil --}}
                <div x-show="activeTab === 'profile'" x-transition:enter="transition-opacity duration-500"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Bagian Bio --}}
                        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl p-6">
                            <h2 class="text-xl font-bold text-white border-b-2 border-primary/50 pb-2 mb-4">
                                Tentang Saya
                            </h2>
                            @if (auth()->user()->bio)
                                <p class="text-gray-300 whitespace-pre-wrap leading-relaxed text-base">
                                    {{ auth()->user()->bio }}
                                </p>
                            @else
                                <div class="text-center py-6 px-4 bg-gray-800/40 rounded-lg">
                                    <p class="text-gray-400 italic">
                                        Anda belum menambahkan bio.
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Bagian Genre Favorit --}}
                        <div class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl p-6">
                            <h2 class="text-xl font-bold text-white border-b-2 border-primary/50 pb-2 mb-4">
                                Genre Favorit
                            </h2>
                            <div class="flex flex-wrap gap-3">
                                @forelse(auth()->user()->genres as $genre)
                                    <span
                                        class="bg-secondary text-gray-200 text-sm font-medium px-4 py-1.5 rounded-full shadow-sm transition-all duration-300 hover:bg-primary hover:shadow-md hover:shadow-red-900/40 cursor-pointer hover:-translate-y-1">
                                        {{ $genre->name }}
                                    </span>
                                @empty
                                    <div class="text-center py-6 px-4 bg-gray-800/40 rounded-lg w-full">
                                        <p class="text-gray-400 italic">
                                            Pilih genre favorit Anda di halaman edit profil.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab Aktivitas --}}
                <div x-show="activeTab === 'activity'" x-transition:enter="transition-opacity duration-500"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="space-y-4">
                        @forelse ($activities as $activity)
                            <div class="activity-item opacity-0 translate-y-4 transform transition-all duration-500 ease-out"
                                style="transition-delay: {{ $loop->index * 75 }}ms">
                                @if ($activity instanceof \App\Models\Thread)
                                    <a href="{{ route('threads.show', [$activity->category, $activity]) }}"
                                        class="group block bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl p-5 transition-all duration-300 hover:border-primary/80 hover:bg-gray-800/70">
                                        <div class="flex items-center gap-4">
                                            <span class="text-blue-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                            <div>
                                                <p class="text-sm text-gray-400">
                                                    Membuat thread baru di kategori <span
                                                        class="font-semibold text-primary">{{ $activity->category->name }}</span>
                                                </p>
                                                <p
                                                    class="font-semibold text-white group-hover:text-primary transition-colors duration-300">
                                                    {{ $activity->title }}</p>
                                            </div>
                                            <span
                                                class="ml-auto text-xs text-gray-500 flex-shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @elseif ($activity instanceof \App\Models\Comment)
                                    <a href="{{ route('threads.show', [$activity->commentable->category, $activity->commentable]) }}#comment-{{ $activity->id }}"
                                        class="group block bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl p-5 transition-all duration-300 hover:border-primary/80 hover:bg-gray-800/70">
                                        <div class="flex items-center gap-4">
                                            <span class="text-green-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                            </span>
                                            <div>
                                                <p class="text-sm text-gray-400">
                                                    Memberi komentar pada thread
                                                </p>
                                                <p
                                                    class="font-semibold text-white group-hover:text-primary transition-colors duration-300">
                                                    {{ $activity->commentable->title }}</p>
                                            </div>
                                            <span
                                                class="ml-auto text-xs text-gray-500 flex-shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div
                                class="text-center bg-gray-800/50 border-2 border-dashed border-gray-700 rounded-2xl p-12">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-semibold text-white">Belum Ada Aktivitas</h3>
                                <p class="mt-1 text-sm text-gray-400">
                                    Mulai diskusi atau beri komentar untuk melihat aktivitas Anda di sini.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
