<div class="flex gap-4">
    {{-- Avatar --}}
    <img class="h-10 w-10 rounded-full flex-shrink-0" src="{{ $comment->author?->avatar_url ?? \Laravolt\Avatar\Facade::create('Guest')->toBase64() }}"
        alt="{{ $comment->author?->name ?? 'Guest' }}">

    <div class="flex-1">
        <div class="bg-gray-700/50 p-4 rounded-lg rounded-tl-none">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-white text-sm">
                @if ($comment->author)
                    <a href="{{ route('users.show', $comment->author->slug) }}" class="font-semibold hover:underline">
                        {{ $comment->author->name }}
                    </a>
                @else
                    <strong class="font-semibold">Pengguna Telah Dihapus</strong>
                @endif
                <span class="text-xs text-gray-400 mt-1 sm:mt-0">{{ $comment->created_at->diffForHumans() }}</span>
            </div>

            {{-- Editing State --}}
            @if ($isEditing)
                <form wire:submit="updateComment" class="mt-2">
                    <textarea wire:model="editBody" class="w-full p-2 text-sm bg-gray-800 text-white rounded-md" rows="3"></textarea>
                    @error('editBody') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <div class="mt-2 flex flex-wrap gap-2">
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700">Update</button>
                        <button type="button" wire:click="cancelEditing" class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded hover:bg-gray-600">Batal</button>
                    </div>
                </form>
            @else
                <p class="text-gray-300 mt-2 text-base whitespace-pre-wrap break-words">{{ $comment->body }}</p>
            @endif
        </div>

        {{-- Actions: Vote, Reply, Edit, Delete --}}
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-sm text-gray-400">
            <livewire:votable-buttons :model="$comment" wire:key="vote-{{ $comment->id }}" />
            <button wire:click="startReplying" class="hover:text-white font-semibold">Balas</button>
            @can('update', $comment)
                <button wire:click="startEditing" class="hover:text-white">Edit</button>
            @endcan
            @can('delete', $comment)
                <button wire:click="confirmDelete"
                        x-on:click="if (!confirm('Anda yakin ingin menghapus komentar ini? Tindakan ini tidak dapat diurungkan.')) { $event.preventDefault() }"
                        class="hover:text-red-500">Hapus</button>
            @endcan
        </div>

        {{-- Reply Form --}}
        @if ($isReplying)
            <form wire:submit="postReply" class="mt-3 ml-0 sm:ml-4">
                <textarea wire:model="replyBody" rows="3" class="w-full p-2 text-sm bg-gray-800 text-white rounded-md" placeholder="Tulis balasan..."></textarea>
                @error('replyBody') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <div class="mt-2 flex flex-wrap gap-2">
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700">Kirim</button>
                    <button type="button" wire:click="cancelReplying" class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded hover:bg-gray-600">Batal</button>
                </div>
            </form>
        @endif

        {{-- Replies Section --}}
        @if ($comment->replies->isNotEmpty())
            <div class="mt-4">
                <button wire:click="toggleReplies" class="text-sm font-semibold text-primary hover:underline">
                    {{ $showReplies ? 'Sembunyikan' : 'Tampilkan' }} {{ $comment->replies->count() }} balasan
                </button>

                @if ($showReplies)
                    <div class="mt-4 space-y-6 border-l-2 border-gray-700 pl-4 sm:pl-6">
                        @foreach ($replies as $reply)
                            {{-- Recursive call to the component for nested replies --}}
                            <livewire:comment-component :comment="$reply" :commentable="$commentable" wire:key="reply-{{ $reply->id }}-{{ $reply->replies->count() }}" />
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

