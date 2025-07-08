<footer class="bg-gray-800/50 backdrop-blur-lg mt-16 border-t border-gray-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div class="md:col-span-1">
                <a href="/" class="transition-transform duration-300 hover:scale-105 inline-block">
                    <h2 class="text-2xl font-bold text-white">delinquent.id</h2>
                </a>
                <p class="mt-4 text-gray-400 text-sm leading-relaxed">
                    Platform forum untuk diskusi bebas dan terbuka mengenai berbagai topik.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white uppercase tracking-wider">Tautan</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Tentang
                            Kami</a></li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-white transition-colors duration-200">Kontak</a></li>
                    <li><a href="#"
                            class="text-gray-400 hover:text-white transition-colors duration-200">Kebijakan Privasi</a>
                    </li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Syarat &
                            Ketentuan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white uppercase tracking-wider">Forum</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('forum.categories.index') }}" class="text-gray-400 hover:text-white transition-colors duration-200">Kategori</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Topik Terbaru</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Topik Populer</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white uppercase tracking-wider">Ikuti Kami</h3>
                <div class="mt-4 flex space-x-5">
                    <a href="#"
                        class="text-gray-400 hover:text-white transition-transform duration-300 hover:scale-110">
                        <span class="sr-only">Twitter</span>
                        {{-- Ikon SVG untuk Twitter --}}
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#"
                        class="text-gray-400 hover:text-white transition-transform duration-300 hover:scale-110">
                        <span class="sr-only">Instagram</span>
                        {{-- Ikon SVG untuk Instagram --}}
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.485 2.525c.636-.247 1.363-.416 2.427-.465C9.93 2.013 10.284 2 12.315 2zm-4.167 3.913a1.5 1.5 0 10-1.5 1.5.75.75 0 001.5 0zm2.083.75a4.5 4.5 0 110 9 4.5 4.5 0 010-9zm-2.25 4.5a2.25 2.25 0 104.5 0 2.25 2.25 0 00-4.5 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-12 pt-8 border-t border-gray-700/50 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} delinquent.id - All Rights Reserved.</p>
        </div>
    </div>
</footer>
