<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            Profil Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{--
                Untuk bagian info profil, kita asumsikan komponen Livewire-mu
                sudah memiliki desain yang baik. Jika belum, terapkan style
                seperti background gradient dan rounded-3xl di dalamnya.
            --}}
            @livewire('user-profile-info', ['user' => $user])


            {{-- === ANTARMUKA TAB KONTEN PENGGUNA === --}}
            <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'threads' }" class="mt-10">

                {{-- Tombol Tab --}}
                <div class="border-b border-slate-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click.prevent="activeTab = 'threads'; window.location.hash = 'threads';"
                            :class="{
                                'border-primary text-primary': activeTab === 'threads',
                                'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-300': activeTab !== 'threads'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Threads
                        </button>

                        <button @click.prevent="activeTab = 'articles'; window.location.hash = 'articles';"
                            :class="{
                                'border-primary text-primary': activeTab === 'articles',
                                'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-300': activeTab !== 'articles'
                            }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Artikel
                        </button>
                    </nav>
                </div>

                {{-- Panel Konten Tab --}}
                <div class="pt-8">
                    {{-- Panel Threads --}}
                    <div x-show="activeTab === 'threads'" id="threads">
                        @if ($threads->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($threads as $thread)
                                    <x-post-card :url="route('threads.show', $thread->slug)" :title="$thread->title" :date="$thread->created_at->translatedFormat('d F Y, H:i')"
                                        :snippet="$thread->body" />
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16 px-6 bg-slate-800/30 rounded-2xl">
                                <h3 class="text-lg font-semibold text-slate-300">Belum Ada Thread</h3>
                                <p class="mt-1 text-sm text-slate-500">Pengguna ini belum membuat thread apapun.</p>
                            </div>
                        @endif

                        <div class="mt-8">
                            @if ($threads->hasPages())
                                {{ $threads->links()->withQueryString()->onEachSide(1)->fragment('threads') }}
                            @endif
                        </div>
                    </div>

                    {{-- Panel Artikel --}}
                    <div x-show="activeTab === 'articles'" id="articles" style="display: none;">
                        @if ($articles->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($articles as $article)
                                    <x-post-card :url="route('articles.show', $article->slug)" :title="$article->title" :date="$article->created_at->translatedFormat('d F Y, H:i')"
                                        :snippet="$article->body" />
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16 px-6 bg-slate-800/30 rounded-2xl">
                                <h3 class="text-lg font-semibold text-slate-300">Belum Ada Artikel</h3>
                                <p class="mt-1 text-sm text-slate-500">Pengguna ini belum menulis artikel apapun.</p>
                            </div>
                        @endif

                        <div class="mt-8">
                            @if ($articles->hasPages())
                                {{ $articles->links()->withQueryString()->onEachSide(1)->fragment('articles') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
