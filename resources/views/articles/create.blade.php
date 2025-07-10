{{-- File: resources/views/articles/create.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-8">
                <h1 class="text-2xl font-bold text-white mb-6">Tulis Artikel Baru</h1>
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('articles.partials.form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>