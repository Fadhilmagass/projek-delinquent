<x-app-layout>
    {{-- Kita akan menggunakan background gradien pada body dari layout utama --}}
    {{-- Pastikan di app.blade.php Anda, class 'bg-gray-900' ditambahkan ke body untuk tema gelap --}}

    <div class="py-12 md:py-20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Kartu Profil dengan Efek Glassmorphism --}}
            <div
                class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl shadow-2xl shadow-black/20 overflow-hidden">
                <div class="p-6 sm:p-8 md:p-10">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-10">

                        {{-- Kolom Kiri: Avatar, Nama, dan Tombol Aksi --}}
                        <div class="flex-shrink-0 flex flex-col items-center text-center md:w-1/3">
                            <div class="relative group">
                                <img class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-gray-600 shadow-lg transition-transform duration-300 group-hover:scale-105"
                                    src="{{ auth()->user()->getAvatarUrl() }}" alt="{{ auth()->user()->name }}'s avatar">
                                <span
                                    class="absolute bottom-2 right-2 bg-green-500 rounded-full h-5 w-5 border-2 border-gray-800"></span>
                            </div>

                            <h1 class="text-3xl font-bold text-white mt-4 break-words">
                                {{ auth()->user()->name }}
                            </h1>

                            @if (auth()->user()->lokasi)
                                <div class="flex items-center gap-2 text-gray-400 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm">{{ auth()->user()->lokasi }}</span>
                                </div>
                            @endif

                            <a href="{{ route('profile.edit') }}"
                                class="mt-6 w-full text-center bg-primary hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg hover:shadow-red-800/30">
                                Edit Profil
                            </a>
                        </div>

                        {{-- Kolom Kanan: Bio dan Genre Favorit --}}
                        <div class="w-full md:w-2/3 mt-6 md:mt-0">
                            {{-- Bagian Bio --}}
                            <div>
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
                                            Anda belum menambahkan bio. <br> Ceritakan sedikit tentang diri Anda!
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Bagian Genre Favorit --}}
                            <div class="mt-8">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
