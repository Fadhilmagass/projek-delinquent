<div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data="{}">
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

    {{-- Modal Content --}}
    <div class="bg-gray-800 rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6 relative z-10">
        <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
            <h3 class="text-xl font-semibold text-white">
                @if ($listType === 'followers')
                    Pengikut
                @elseif ($listType === 'following')
                    Mengikuti
                @endif
            </h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="max-h-96 overflow-y-auto space-y-3">
            @forelse ($usersInList as $userInList)
                <a href="{{ route('users.show', $userInList->slug) }}" wire:click="closeModal"
                    class="flex items-center space-x-3 p-2 rounded-md hover:bg-gray-700 transition">
                    <img class="w-10 h-10 rounded-full object-cover" src="{{ $userInList->avatar_url }}"
                        alt="{{ $userInList->name }}">
                    <div>
                        <p class="text-white font-medium">{{ $userInList->name }}</p>
                        <p class="text-sm text-gray-400">{{ '@' . $userInList->slug }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-400 text-center py-4">Tidak ada pengguna dalam daftar ini.</p>
            @endforelse
        </div>
    </div>
</div>