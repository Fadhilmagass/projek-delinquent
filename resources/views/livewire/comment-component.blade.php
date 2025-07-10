<div wire:key="comment-{{ $comment->id }}" class="mb-6">
    {{-- Comment Display --}}
    <div class="flex gap-4">
        @if ($comment->author)
            <img class="h-10 w-10 rounded-full" src="{{ $comment->author->getAvatarUrl() }}"
                alt="{{ $comment->author->name }}">
        @else
            {{-- Fallback for deleted or non-existent author --}}
            <img class="h-10 w-10 rounded-full" src="{{ \Laravolt\Avatar\Facade::create('Guest')->toBase64() }}"
                alt="Guest Avatar">
        @endif

        <div class="flex-1">
            <div class="bg-gray-700/50 p-4 rounded-lg rounded-tl-none">
                <div class="flex justify-between text-white text-sm">
                    <strong>{{ $comment->author ? $comment->author->name : 'Pengguna Tidak Ditemukan' }}</strong>
                    <span class="text-xs text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>

                {{-- Editing --}}
                @if ($isEditing)
                    <form wire:submit.prevent="updateComment">
                        <textarea wire:model.defer="editBody" class="w-full p-2 text-sm bg-gray-800 text-white rounded-md" rows="3"></textarea>
                        @error('editBody')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div class="mt-2 flex gap-2">
                            <button type="submit"
                                class="px-4 py-1 bg-green-600 text-white text-sm rounded">Update</button>
                            <button type="button" wire:click="cancelEditing"
                                class="px-4 py-1 bg-gray-500 text-white text-sm rounded">Cancel</button>
                        </div>
                    </form>
                @else
                    <p class="text-gray-300 mt-2">{{ nl2br(e($comment->body)) }}</p>
                @endif

                {{-- Edit/Delete Actions --}}
                @if (auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->can('delete', $comment)))
                    <div class="flex gap-4 mt-2 text-sm text-gray-400">
                        @can('update', $comment)
                            <button wire:click="startEditing" class="hover:text-white">Edit</button>
                        @endcan
                        @can('delete', $comment)
                            <button wire:click="confirmDelete"
                                x-on:click="if (!confirm('Apakah kamu yakin ingin menghapus komentar ini?')) $event.preventDefault()"
                                class="hover:text-red-500">Delete</button>
                        @endcan
                    </div>
                @endif
            </div>

            {{-- Comment Actions --}}
            <div class="flex items-center gap-4 mt-2 text-sm text-gray-400">
                <livewire:votable-buttons :model="$comment" :wire:key="'comment-vote-'.$comment->id" />

                <button wire:click="startReplying" class="hover:text-white">Reply</button>

                @if ($comment->replies()->count())
                    <button wire:click="toggleReplies" class="hover:text-white">
                        {{ $showReplies ? 'Hide' : 'Show' }} Replies ({{ $comment->replies()->count() }})
                    </button>
                @endif
            </div>

            {{-- Reply Form --}}
            @if ($isReplying)
                <form wire:submit.prevent="postReply" class="mt-3">
                    <textarea wire:model.defer="replyBody" rows="3" class="w-full p-2 text-sm bg-gray-800 text-white rounded-md"
                        placeholder="Write a reply..."></textarea>
                    @error('replyBody')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="mt-2 flex gap-2">
                        <button type="submit" class="px-4 py-1 bg-blue-600 text-white text-sm rounded">Post</button>
                        <button type="button" wire:click="cancelReplying"
                            class="px-4 py-1 bg-gray-500 text-white text-sm rounded">Cancel</button>
                    </div>
                </form>
            @endif

            {{-- Replies --}}
            @if ($showReplies)
                <div class="mt-4 space-y-4 border-l-2 border-gray-600 pl-4">
                    @foreach ($replies as $reply)
                        <livewire:comment-component :comment="$reply" :commentable="$commentable"
                            wire:key="reply-{{ $reply->id }}" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
