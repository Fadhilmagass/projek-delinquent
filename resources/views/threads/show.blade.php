<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumbs --}}
            <div class="mb-4 text-sm text-gray-400">
                <a href="{{ route('forum.index') }}" class="hover:text-primary">Forum</a>
                &raquo;
                <a href="{{ route('forum.categories.show', $thread->category->slug) }}" class="hover:text-primary">{{ $thread->category->name }}</a>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    {{-- Tombol Vote untuk Thread --}}
                    <div class="flex-shrink-0 mx-auto sm:mx-0">
                        <livewire:votable-buttons :model="$thread" :wire:key="'thread-vote-'.$thread->id" />
                    </div>

                    <div class="flex-1">
                        {{-- Judul dan Info Author --}}
                        <h1 class="text-3xl font-bold text-white">{{ $thread->title }}</h1>
                        <div class="flex items-center gap-4 mt-2">
                            <img class="h-8 w-8 rounded-full" src="{{ $thread->author->getAvatarUrl() }}" alt="">
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $thread->author->name }}</p>
                                <p class="text-xs text-gray-400">Diposting {{ $thread->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        @can('update', $thread)
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('forum.threads.edit', $thread->slug) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Edit Thread
                                </a>

                                <form action="{{ route('forum.threads.destroy', $thread->slug) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus thread ini?')">
                                        Hapus Thread
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>

                {{-- Isi Thread --}}
                <div class="prose prose-invert prose-lg mt-6 text-gray-300 border-t border-gray-700 pt-6">
                    {!! $thread->body !!}
                </div>
            </div>

            {{-- Komponen Komentar --}}
            <div class="mt-8">
                <livewire:show-comments :model="$thread" :key="'comments-for-thread-' . $thread->id" />
            </div>
        </div>
    </div>
</x-app-layout>
