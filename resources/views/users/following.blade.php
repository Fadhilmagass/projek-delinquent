<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{-- Menggunakan kontras warna yang lebih nyaman --}}
            <span class="text-slate-400">Daftar yang diikuti oleh:</span> {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-br from-gray-900 via-gray-900 to-black text-white rounded-3xl shadow-2xl shadow-primary/10 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <h3 class="text-2xl font-bold mb-8 text-slate-200 border-b border-slate-700 pb-4">
                        Daftar Pengguna yang Diikuti
                    </h3>

                    {{-- Memeriksa apakah koleksi tidak kosong sebelum membuat grid --}}
                    @if ($following->count() > 0)
                        {{-- Menggunakan Grid untuk layout yang responsif --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($following as $followedUser)
                                {{-- Desain kartu untuk setiap user yang diikuti --}}
                                <div
                                    class="group bg-slate-800/50 rounded-2xl p-6 text-center flex flex-col items-center
                                            border border-slate-700
                                            transition-all duration-300 ease-in-out
                                            hover:border-primary/50 hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-1">

                                    {{-- Avatar yang lebih besar dan menonjol --}}
                                    <img class="w-24 h-24 rounded-full object-cover mb-4
                                                ring-2 ring-slate-700 group-hover:ring-primary
                                                transition-all duration-300"
                                        src="{{ $followedUser->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($followedUser->name) . '&background=random' }}"
                                        alt="{{ $followedUser->name }}">

                                    <div class="flex-grow">
                                        <a href="{{ route('users.show', $followedUser->slug) }}"
                                            class="text-lg font-bold text-slate-200 group-hover:text-primary transition-colors">
                                            {{ $followedUser->name }}
                                        </a>
                                        <p class="text-sm text-slate-400 mb-4">{{ '@' . $followedUser->slug }}</p>
                                    </div>

                                    {{-- Tombol akan berada di bagian bawah kartu --}}
                                    @if (auth()->user()->isNot($followedUser))
                                        <div class="w-full mt-auto">
                                            <livewire:follow-button :user="$followedUser" :is-followed-by-auth-user="auth()->user()->isFollowing($followedUser)" />
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Desain "Empty State" yang lebih menarik --}}
                        <div
                            class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 px-6 bg-slate-800/30 rounded-2xl">
                            <svg class="mx-auto h-12 w-12 text-slate-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-semibold text-slate-300">Belum ada yang diikuti</h3>
                            <p class="mt-1 text-sm text-slate-500">Saat {{ $user->name }} mengikuti seseorang, mereka
                                akan muncul di sini.</p>
                        </div>
                    @endif

                    {{-- Pagination dengan margin atas --}}
                    <div class="mt-8">
                        @if ($following->hasPages())
                            {{ $following->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
