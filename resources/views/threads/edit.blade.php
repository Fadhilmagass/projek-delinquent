<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-lg p-6 sm:p-8">
                <h1 class="text-2xl font-bold text-white mb-6">Edit Thread</h1>

                <form method="POST" action="{{ route('forum.threads.update', $thread->slug) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Judul Thread')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $thread->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Kategori')" />
                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-700 bg-gray-900 text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $thread->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <!-- Body -->
                    <div class="mt-4">
                        <x-input-label for="body" :value="__('Isi Thread')" />
                        <x-textarea-input id="body" class="block mt-1 w-full" name="body" required>{{ old('body', $thread->body) }}</x-textarea-input>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Perbarui Thread') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
