<div class="flex items-center gap-2">
    <button wire:click="vote(1)" class="p-2 rounded-full hover:bg-gray-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 {{ $model->votes()->where('user_id', auth()->id())->where('vote', 1)->exists()? 'text-primary': 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
    <span class="text-xl font-bold text-white w-8 text-center">{{ $voteScore }}</span>
    <button wire:click="vote(-1)" class="p-2 rounded-full hover:bg-gray-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 {{ $model->votes()->where('user_id', auth()->id())->where('vote', -1)->exists()? 'text-primary': 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
</div>
