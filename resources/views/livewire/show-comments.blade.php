<div class="mt-8">
    <h2 class="text-2xl font-bold text-white mb-4">Komentar ({{ $model->comments->count() }})</h2>

    {{-- Comment Form --}}
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

    {{-- Comments List --}}
    <div class="space-y-8">
        @forelse ($comments as $comment)
            {{-- Use a unique wire:key for each top-level comment --}}
            <livewire:comment-component :comment="$comment" :commentable="$model" wire:key="comment-{{ $comment->id }}-{{ $comment->replies->count() }}" />
        @empty
            <p class="text-gray-500 text-center">Belum ada komentar. Jadilah yang pertama!</p>
        @endforelse
    </div>
</div>
