<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{-- Menggunakan text-slate-200 untuk kontras yang lebih nyaman --}}
            <span class="text-slate-400">Pengikut dari:</span> {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Wadah utama tetap, mungkin sedikit lebih lebar dengan max-w-7xl --}}
            <div
                class="bg-gradient-to-br from-gray-900 via-gray-900 to-black text-white rounded-3xl shadow-2xl shadow-primary/10 overflow-hidden">
                <div class="p-6 sm:p-10">
                    <h3 class="text-2xl font-bold mb-8 text-slate-200 border-b border-slate-700 pb-4">
                        Daftar Pengikut
                    </h3>

                    {{-- Menggunakan Grid untuk layout yang responsif --}}
                    @if ($followers->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($followers as $follower)
                                {{-- Desain kartu untuk setiap pengikut --}}
                                <div
                                    class="group bg-slate-800/50 rounded-2xl p-6 text-center flex flex-col items-center
                                            border border-slate-700
                                            transition-all duration-300 ease-in-out
                                            hover:border-primary/50 hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-1">

                                    {{-- Avatar yang lebih besar dan menonjol --}}
                                    <img class="w-24 h-24 rounded-full object-cover mb-4
                                                ring-2 ring-slate-700 group-hover:ring-primary
                                                transition-all duration-300"
                                        src="{{ $follower->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($follower->name) . '&background=random' }}"
                                        alt="{{ $follower->name }}">

                                    <div class="flex-grow">
                                        <a href="{{ route('users.show', $follower->slug) }}"
                                            class="text-lg font-bold text-slate-200 group-hover:text-primary transition-colors">
                                            {{ $follower->name }}
                                        </a>
                                        <p class="text-sm text-slate-400 mb-4">{{ '@' . $follower->slug }}</p>
                                    </div>

                                    {{-- Tombol akan berada di bagian bawah kartu --}}
                                    @if (auth()->user()->isNot($follower))
                                        <div class="w-full mt-auto">
                                            <livewire:follow-button :user="$follower" :is-followed-by-auth-user="auth()->user()->isFollowing($follower)" />
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
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-semibold text-slate-300">Belum ada pengikut</h3>
                            <p class="mt-1 text-sm text-slate-500">Saat ada yang mengikuti {{ $user->name }}, mereka
                                akan muncul di sini.</p>
                        </div>
                    @endif

                    {{-- Pagination dengan margin atas --}}
                    <div class="mt-8">
                        @if ($followers->hasPages())
                            {{ $followers->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
