<div>
    @auth
        @if (\Illuminate\Support\Facades\Auth::user()->id !== $user->id)
            <button wire:click="toggleFollow"
                class="{{ $isFollowing ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white font-bold py-2 px-4 rounded-full text-sm">
                {{ $isFollowing ? 'Berhenti Mengikuti' : 'Ikuti' }}
            </button>
        @endif
    @else
        <a href="{{ route('login') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full text-sm">
            Ikuti
        </a>
    @endauth
</div>
