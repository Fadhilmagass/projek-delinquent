<x-app-layout>
    <div class="pt-6 md:pt-10 pb-12" x-data="{
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
            document.querySelectorAll('.activity-item').forEach(el => observer.observe(el))
        }
    }" x-init="observe()">
        <div class="max-w-5xl mx-auto sm:px-4 lg:px-6">
            {{-- Kartu Profil Utama --}}
            <div class="bg-gray-800/50 border border-gray-700/40 rounded-xl shadow-lg shadow-black/10 overflow-hidden">
                <div class="p-5 sm:p-8 flex flex-col md:flex-row gap-6 md:gap-10 items-center md:items-start">
                    {{-- Avatar --}}
                    <div class="relative group">
                        <img class="w-28 h-28 md:w-36 md:h-36 rounded-full object-cover border-4 border-gray-600 shadow-md group-hover:scale-105 transition duration-300"
                            src="{{ auth()->user()->getAvatarUrl() }}" alt="{{ auth()->user()->name }}">
                        <span
                            class="absolute bottom-2 right-2 bg-green-500 border-2 border-gray-900 h-4 w-4 rounded-full"></span>
                    </div>

                    {{-- Info Pengguna --}}
                    <div class="flex-grow text-center md:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ auth()->user()->name }}</h1>

                        @if (auth()->user()->lokasi)
                            <div class="flex items-center justify-center md:justify-start text-sm text-gray-400 mt-1">
                                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ auth()->user()->lokasi }}
                            </div>
                        @endif

                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                            <div class="bg-gray-700/40 px-4 py-2 rounded text-center">
                                <p class="text-xl font-bold text-primary">{{ auth()->user()->threads_count }}</p>
                                <p class="text-xs text-gray-400 uppercase">Threads</p>
                            </div>
                            <div class="bg-gray-700/40 px-4 py-2 rounded text-center">
                                <p class="text-xl font-bold text-primary">{{ auth()->user()->comments_count }}</p>
                                <p class="text-xs text-gray-400 uppercase">Komentar</p>
                            </div>
                            <div class="bg-gray-700/40 px-4 py-2 rounded text-center">
                                <p class="text-xl font-bold text-primary">
                                    {{ auth()->user()->created_at->diffForHumans(null, true) }}</p>
                                <p class="text-xs text-gray-400 uppercase">Bergabung</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Edit --}}
                    <div class="md:mt-0">
                        <a href="{{ route('profile.edit') }}"
                            class="inline-block bg-primary hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition-all duration-300">
                            Edit Profil
                        </a>
                    </div>
                </div>

                {{-- Navigasi Tab --}}
                <div class="border-t border-gray-700/50 px-4">
                    <nav class="flex space-x-6 pt-3 text-sm font-medium" aria-label="Tabs">
                        <button @click="activeTab = 'profile'"
                            :class="{ 'border-primary text-primary': activeTab === 'profile', 'text-gray-400 hover:text-white': activeTab !== 'profile' }"
                            class="pb-2 border-b-2 transition-all">
                            Profil
                        </button>
                        <button @click="activeTab = 'activity'"
                            :class="{ 'border-primary text-primary': activeTab === 'activity', 'text-gray-400 hover:text-white': activeTab !== 'activity' }"
                            class="pb-2 border-b-2 transition-all">
                            Aktivitas Terbaru
                        </button>
                    </nav>
                </div>
            </div>

            {{-- Konten Tab --}}
            <div class="mt-6">
                {{-- Tab Profil --}}
                <div x-show="activeTab === 'profile'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bio --}}
                        <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-5">
                            <h2 class="text-lg font-semibold text-white border-b border-primary/40 pb-2 mb-3">Tentang
                                Saya</h2>
                            @if (auth()->user()->bio)
                                <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ auth()->user()->bio }}
                                </p>
                            @else
                                <p class="text-gray-500 italic">Anda belum menambahkan bio.</p>
                            @endif
                        </div>

                        {{-- Genre Favorit --}}
                        <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-5">
                            <h2 class="text-lg font-semibold text-white border-b border-primary/40 pb-2 mb-3">Genre
                                Favorit</h2>
                            <div class="flex flex-wrap gap-3">
                                @forelse(auth()->user()->genres as $genre)
                                    <span
                                        class="bg-secondary text-sm text-white font-medium px-4 py-1.5 rounded-full hover:bg-primary transition-all duration-200">
                                        {{ $genre->name }}
                                    </span>
                                @empty
                                    <p class="text-gray-500 italic">Pilih genre favorit di halaman edit profil.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tab Aktivitas --}}
                <div x-show="activeTab === 'activity'" x-transition>
                    <div class="space-y-4 mt-4">
                        @forelse ($activities as $activity)
                            {{-- Komponen Aktivitas --}}
                            <div class="activity-item opacity-0 translate-y-4 transform transition-all duration-500 ease-out"
                                style="transition-delay: {{ $loop->index * 50 }}ms">
                                @if ($activity instanceof \App\Models\Thread)
                                    <a href="{{ route('threads.show', [$activity->category, $activity]) }}"
                                        class="block bg-gray-800/40 border border-gray-700/40 rounded-xl p-4 hover:border-primary transition duration-200">
                                        <div class="flex items-center gap-4">
                                            <span class="text-blue-400">
                                                <x-heroicon-o-document-text class="h-5 w-5" />
                                            </span>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-400">
                                                    Thread di <span
                                                        class="text-primary">{{ $activity->category->name }}</span>
                                                </p>
                                                <p class="text-white font-semibold line-clamp-1">{{ $activity->title }}
                                                </p>
                                            </div>
                                            <span
                                                class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @elseif ($activity instanceof \App\Models\Comment)
                                    <a href="{{ route('threads.show', [$activity->commentable->category, $activity->commentable]) }}#comment-{{ $activity->id }}"
                                        class="block bg-gray-800/40 border border-gray-700/40 rounded-xl p-4 hover:border-primary transition duration-200">
                                        <div class="flex items-center gap-4">
                                            <span class="text-green-400">
                                                <x-heroicon-o-chat-bubble-left-ellipsis class="h-5 w-5" />
                                            </span>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-400">Komentar pada</p>
                                                <p class="text-white font-semibold line-clamp-1">
                                                    {{ $activity->commentable->title }}</p>
                                            </div>
                                            <span
                                                class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div
                                class="text-center py-12 border border-dashed border-gray-700 rounded-xl bg-gray-800/40">
                                <p class="text-white text-lg font-semibold">Belum ada aktivitas</p>
                                <p class="text-sm text-gray-400">Mulai membuat thread atau komentar agar muncul di sini.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
