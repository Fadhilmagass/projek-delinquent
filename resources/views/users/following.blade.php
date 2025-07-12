<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white tracking-tight">
            {{ __('Mengikuti') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white rounded-3xl shadow-lg overflow-hidden p-6 sm:p-10">

                <h4 class="text-xl font-bold mb-4">Daftar Mengikuti</h4>

                @forelse ($following as $followedUser)
                    <div class="flex items-center space-x-4 bg-gray-900 border border-gray-700 rounded-xl p-4 mb-3 hover:bg-gray-800 transition">
                        <img class="w-12 h-12 rounded-full object-cover ring-1 ring-primary"
                            src="{{ $followedUser->avatar_url ?? 'https://via.placeholder.com/150' }}" alt="{{ $followedUser->name }}">
                        <div>
                            <a href="{{ route('users.show', $followedUser->slug) }}" class="text-lg font-semibold hover:text-primary transition">
                                {{ $followedUser->name }}
                            </a>
                            <p class="text-sm text-gray-400">{{ '@' . $followedUser->slug }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 py-4 px-5 bg-gray-900 border border-gray-700 rounded-xl">Tidak mengikuti siapa pun.</p>
                @endforelse

                <div class="mt-4">
                    @if ($following->hasPages())
                        {{ $following->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>