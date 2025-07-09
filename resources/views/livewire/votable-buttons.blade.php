<div class="flex items-center gap-2">
    {{-- Tombol Upvote --}}
    <button wire:click="vote('upvote')" class="p-1 rounded-full hover:bg-gray-700 transition">
        <svg @class([
            'h-6 w-6',
            'text-primary' => $userVote === 'upvote',
            'text-gray-400' => $userVote !== 'upvote',
        ]) xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    {{-- Skor --}}
    <span class="text-xl font-bold text-white w-8 text-center">{{ $score }}</span>

    {{-- Tombol Downvote --}}
    <button wire:click="vote('downvote')" class="p-1 rounded-full hover:bg-gray-700 transition">
        <svg @class([
            'h-6 w-6',
            'text-primary' => $userVote === 'downvote',
            'text-gray-400' => $userVote !== 'downvote',
        ]) xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
</div>
