<div class="flex flex-col sm:flex-row sm:items-center space-y-6 sm:space-y-0 sm:space-x-6">
    <img class="w-24 h-24 rounded-full object-cover ring-2 ring-primary shadow-md hover:scale-105 transition"
        src="{{ $user->avatar_url ?? 'https://via.placeholder.com/150' }}" alt="{{ $user->name }}">

    <div class="flex-1">
        <h3 class="text-3xl font-extrabold">{{ $user->name }}</h3>
        <p class="text-sm text-gray-400">{{ '@' . $user->slug }}</p>

        @if ($user->bio)
            <p class="mt-3 text-gray-300 leading-relaxed">{{ $user->bio }}</p>
        @endif

        <div class="flex items-center space-x-4 mt-3 text-sm text-gray-400">
            <span>Bergabung sejak {{ $user->created_at->translatedFormat('d M Y') }}</span>
            <span>&bull;</span>
            <a href="{{ route('users.followers', $user->slug) }}" class="hover:text-white transition cursor-pointer">
                {{ $user->followers->count() }} Pengikut
            </a>
            <span>&bull;</span>
            <a href="{{ route('users.following', $user->slug) }}" class="hover:text-white transition cursor-pointer">
                Mengikuti {{ $user->following->count() }}
            </a>
        </div>

        <div class="mt-4">
            @livewire('follow-button', ['user' => $user, 'isFollowedByAuthUser' => \Illuminate\Support\Facades\Auth::check() && $user->isFollowing(\Illuminate\Support\Facades\Auth::user())])
        </div>

    </div>
</div>
