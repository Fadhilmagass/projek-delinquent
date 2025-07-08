@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-gray-800/50 backdrop-blur-lg border border-gray-700/50 rounded-2xl shadow-2xl shadow-black/20">
                <form action="{{ route('threads.store', $category) }}" method="POST" x-data="{ isSubmitting: false }"
                    x-on:submit="isSubmitting = true">
                    @csrf

                    <div class="p-6 md:p-8 border-b border-gray-700/50">
                        <h1 class="text-3xl font-extrabold text-white tracking-tight">Mulai Diskusi Baru</h1>
                        <p class="mt-1 text-gray-400">
                            di kategori: <span class="font-semibold text-primary">{{ $category->name }}</span>
                        </p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="mb-6">
                            <label for="title"
                                class="block text-sm font-medium leading-6 text-gray-300 mb-2">Judul</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="block w-full rounded-md border-0 bg-gray-700/50 py-2.5 px-4 text-white shadow-sm ring-1 ring-inset ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 transition-colors duration-200"
                                placeholder="Apa yang ingin Anda diskusikan?" required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{ content: @js(old('body', '')) }">
                            <label for="body" class="block text-sm font-medium leading-6 text-gray-300 mb-2">Isi
                                Thread</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <textarea id="body" name="body" rows="15" x-model.debounce.300ms="content"
                                        class="block w-full h-full rounded-md border-0 bg-gray-700/50 py-2.5 px-4 text-white shadow-sm ring-1 ring-inset ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 font-mono transition-colors duration-200"
                                        placeholder="Tulis konten Anda di sini. Markdown didukung." required></textarea>
                                    @error('body')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    {{-- PERUBAHAN DI SINI --}}
                                    <div class="prose prose-invert prose-sm max-w-none h-full rounded-md bg-gray-900/40 border border-gray-700 p-4"
                                        x-html="window.marked.parse(content || '<p class=\'text-gray-500\'>Pratinjau akan muncul di sini...</p>')">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-4 flex items-center justify-end gap-x-4 bg-gray-800/60 p-6 border-t border-gray-700/50">
                        <a href="{{ route('threads.index', $category) }}"
                            class="text-sm font-semibold leading-6 text-gray-300 hover:text-white transition-colors duration-200">Batal</a>
                        <button type="submit" :disabled="isSubmitting"
                            class="inline-flex items-center gap-2 rounded-md bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-300 ease-in-out transform hover:scale-105 disabled:opacity-75 disabled:scale-100">
                            <svg x-show="!isSubmitting" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isSubmitting ? 'Memproses...' : 'Publikasikan'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
