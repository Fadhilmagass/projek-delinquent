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
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Kartu Profil --}}
            <div class="bg-gray-800/60 border border-gray-700 rounded-2xl shadow-lg">
                <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-6 md:gap-10 items-center md:items-start">
                    {{-- Avatar --}}
                    <div class="relative group">
                        <img class="w-28 h-28 md:w-36 md:h-36 rounded-full object-cover border-4 border-gray-600 shadow-md transition-transform group-hover:scale-105 duration-300"
                            src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                        <span
                            class="absolute bottom-2 right-2 bg-green-500 border-2 border-gray-900 h-4 w-4 rounded-full"></span>
                    </div>

                    {{-- Informasi Pengguna --}}
                    <div class="flex-grow text-center md:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ auth()->user()->name }}</h1>
                        @if (auth()->user()->lokasi)
                            <div
                                class="mt-1 text-sm text-gray-400 flex justify-center md:justify-start items-center gap-1">
                                <x-icons.location class="w-4 h-4" />
                                {{ auth()->user()->lokasi }}
                            </div>
                        @endif

                        {{-- Statistik --}}
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                            @foreach ([['label' => 'Threads', 'value' => auth()->user()->threads_count, 'route' => null], ['label' => 'Komentar', 'value' => auth()->user()->comments_count, 'route' => null], ['label' => 'Pengikut', 'value' => auth()->user()->followers_count, 'route' => 'users.followers'], ['label' => 'Mengikuti', 'value' => auth()->user()->following_count, 'route' => 'users.following'], ['label' => 'Bergabung', 'value' => auth()->user()->created_at->diffForHumans(null, true), 'route' => null]] as $stat)
                                @if ($stat['route'])
                                    <a href="{{ route($stat['route'], auth()->user()->slug) }}"
                                        class="bg-gray-700/40 px-4 py-2 rounded text-center hover:bg-gray-600 transition w-[110px]">
                                        <p class="text-xl font-bold text-primary">{{ $stat['value'] }}</p>
                                        <p class="text-xs text-gray-400 uppercase">{{ $stat['label'] }}</p>
                                    </a>
                                @else
                                    <div
                                        class="bg-gray-700/40 px-4 py-2 rounded text-center hover:bg-gray-600 transition w-[110px]">
                                        <p class="text-xl font-bold text-primary">{{ $stat['value'] }}</p>
                                        <p class="text-xs text-gray-400 uppercase">{{ $stat['label'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Tombol Edit --}}
                    <div class="w-full md:w-auto text-center md:text-right">
                        <a href="{{ route('profile.edit') }}"
                            class="bg-primary hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition duration-300">
                            Edit Profil
                        </a>
                    </div>
                </div>

                {{-- Tab Navigasi --}}
                <div class="border-t border-gray-700 px-6">
                    <nav class="flex space-x-6 pt-4 text-sm font-medium justify-center md:justify-start">
                        <button @click="activeTab = 'profile'"
                            :class="activeTab === 'profile' ? 'border-primary text-primary' : 'text-gray-400 hover:text-white'"
                            class="pb-2 border-b-2 transition">
                            Profil
                        </button>
                        <button @click="activeTab = 'activity'"
                            :class="activeTab === 'activity' ? 'border-primary text-primary' : 'text-gray-400 hover:text-white'"
                            class="pb-2 border-b-2 transition">
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
                                <p class="text-gray-300 whitespace-pre-line leading-relaxed">{{ auth()->user()->bio }}
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
                                        class="bg-secondary text-sm text-white font-medium px-4 py-1.5 rounded-full hover:bg-primary transition-all">
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
                                    <a href="{{ route('threads.show', $activity->slug) }}"
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
                                @elseif ($activity instanceof \App\Models\Article)
                                    <a href="{{ route('articles.show', $activity) }}"
                                        class="block bg-gray-800/40 border border-gray-700/40 rounded-xl p-4 hover:border-primary transition duration-200">
                                        <div class="flex items-center gap-4">
                                            <span class="text-yellow-400">
                                                <x-heroicon-o-newspaper class="h-5 w-5" />
                                            </span>
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-400">
                                                    Article in <span
                                                        class="text-primary">{{ $activity->categories->first()->name }}</span>
                                                </p>
                                                <p class="text-white font-semibold line-clamp-1">{{ $activity->title }}
                                                </p>
                                            </div>
                                            <span
                                                class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                @elseif ($activity instanceof \App\Models\Comment)
                                    @if ($activity->commentable instanceof \App\Models\Thread)
                                        <a href="{{ route('threads.show', $activity->commentable->slug) }}#comment-{{ $activity->id }}"
                                            class="block bg-gray-800/40 border border-gray-700/40 rounded-xl p-4 hover:border-primary transition duration-200">
                                        @elseif ($activity->commentable instanceof \App\Models\Article)
                                            <a href="{{ route('articles.show', $activity->commentable) }}#comment-{{ $activity->id }}"
                                                class="block bg-gray-800/40 border border-gray-700/40 rounded-xl p-4 hover:border-primary transition duration-200">
                                    @endif
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
