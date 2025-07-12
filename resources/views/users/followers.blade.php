<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{ __('Pengikut') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white rounded-3xl shadow-lg overflow-hidden p-6 sm:p-10">

                <h4 class="text-xl font-bold mb-4">Daftar Pengikut</h4>

                @forelse ($followers as $follower)
                    <div class="flex items-center space-x-4 bg-gray-900 border border-gray-700 rounded-xl p-4 mb-3 hover:bg-gray-800 transition">
                        <img class="w-12 h-12 rounded-full object-cover ring-1 ring-primary"
                            src="{{ $follower->avatar_url ?? 'https://via.placeholder.com/150' }}" alt="{{ $follower->name }}">
                        <div>
                            <a href="{{ route('users.show', $follower->slug) }}" class="text-lg font-semibold hover:text-primary transition">
                                {{ $follower->name }}
                            </a>
                            <p class="text-sm text-gray-400">{{ '@' . $follower->slug }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 py-4 px-5 bg-gray-900 border border-gray-700 rounded-xl">Tidak ada pengikut.</p>
                @endforelse

                <div class="mt-4">
                    @if ($followers->hasPages())
                        {{ $followers->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>