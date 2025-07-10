<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-8">
                <h1 class="text-2xl font-bold text-white mb-6">Edit Artikel</h1>
                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('articles.partials.form', ['article' => $article])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>