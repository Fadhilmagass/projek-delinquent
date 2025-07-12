{{-- resources/views/components/post-card.blade.php --}}
@props(['url', 'title', 'date', 'snippet'])

<a href="{{ $url }}"
    class="group block bg-slate-800/50 rounded-2xl p-6 border border-slate-700
                           transition-all duration-300 ease-in-out
                           hover:border-primary/50 hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-1">
    <div class="flex flex-col h-full">
        <h3 class="text-lg font-bold text-slate-200 group-hover:text-primary transition-colors">
            {{ $title }}
        </h3>

        <p class="text-xs text-slate-400 mt-2">
            {{ $date }}
        </p>

        <p class="mt-3 text-sm text-slate-300 line-clamp-3 flex-grow">
            {{ $snippet }}
        </p>

        <div class="mt-4 text-sm font-semibold text-primary/80 group-hover:text-primary transition-colors">
            Baca lebih lanjut &rarr;
        </div>
    </div>
</a>
