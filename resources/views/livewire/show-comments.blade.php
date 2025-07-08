<div class="mt-8">
    <h2 class="text-2xl font-bold text-white mb-4">Komentar ({{ $thread->comments->count() }})</h2>

    {{-- Form Komentar --}}
    @auth
        <form wire:submit.prevent="postComment" class="mb-8">
            <textarea wire:model.defer="body" rows="4"
                class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6"
                placeholder="Tulis komentar Anda..."></textarea>
            @error('body')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <div class="mt-2 text-right">
                <button type="submit"
                    class="rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700">Kirim</button>
            </div>
        </form>
    @else
        <div class="mb-8 p-4 bg-gray-800/50 border border-gray-700 rounded-lg text-center text-gray-400">
            <a href="{{ route('login') }}" class="font-bold text-primary hover:underline">Login</a> untuk memberikan
            komentar.
        </div>
    @endauth


    {{-- Daftar Komentar --}}
    <div class="space-y-6">
        @forelse ($thread->comments as $comment)
            <div class="flex gap-4">
                @if ($comment->author)
                    <img class="h-10 w-10 rounded-full flex-shrink-0" src="{{ $comment->author->getAvatarUrl() }}"
                        alt="{{ $comment->author->name }}">
                    <div class="flex-1">
                        <div class="bg-gray-700/50 p-4 rounded-lg rounded-tl-none">
                            <div class="flex justify-between">
                                <span class="font-bold text-white">{{ $comment->author->name }}</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-300 mt-2">{{ $comment->body }}</p>
                        </div>
                        {{-- Tombol Vote untuk Komentar --}}
                        <livewire:votable-buttons :model="$comment" :wire:key="'comment-vote-'.$comment->id" />
                    </div>
                @else
                    <img class="h-10 w-10 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name=User+Deleted&color=7F9CF5&background=EBF4FF"
                        alt="User Deleted">
                    <div class="flex-1">
                        <div class="bg-gray-700/50 p-4 rounded-lg rounded-tl-none">
                            <div class="flex justify-between">
                                <span class="font-bold text-white italic">User Deleted</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-300 mt-2">{{ $comment->body }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center">Belum ada komentar.</p>
        @endforelse
    </div>
</div>
