<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delinquent - Community</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=bebas-neue:400|instrument-sans:400,500,600&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --red-600: #DC2626;
            --gray-900: #111827;
        }

        .font-bebas {
            font-family: 'Bebas Neue', sans-serif;
        }

        .font-instrument-sans {
            font-family: 'Instrument Sans', sans-serif;
        }

        .header-scrolled {
            background-color: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom-color: rgba(55, 65, 81, 0.5);
        }

        @supports not ((-webkit-backdrop-filter: none) or (backdrop-filter: none)) {
            .header-scrolled {
                background-color: var(--gray-900);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        [data-scroll-animation] {
            opacity: 0;
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        [data-scroll-animation="fade-in"] {
            transform: translateY(20px);
        }

        [data-scroll-animation="slide-in-left"] {
            transform: translateX(-30px);
        }

        [data-scroll-animation="slide-in-right"] {
            transform: translateX(30px);
        }

        .is-visible {
            opacity: 1;
            transform: translate(0, 0);
        }
    </style>
</head>

<body class="bg-gray-900 text-white font-instrument-sans antialiased">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <video playsinline autoplay muted loop poster="/images/fallback-background.jpg"
            class="object-cover w-full h-full">
            <source src="/videos/background-video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute top-0 left-0 w-full h-full bg-black/60"></div>
    </div>

    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="container mx-auto flex items-center justify-between p-6 border-b border-transparent">
            <div class="flex items-center gap-6">
                <button id="menu-btn" class="z-50 text-white focus:outline-none lg:hidden" aria-label="Open menu"
                    aria-controls="side-menu" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <a href="/" class="text-2xl font-bold font-bebas tracking-wider text-white">
                    DELINQUENT
                </a>
            </div>

            <div class="hidden lg:flex items-center gap-6">
                <a href="/about" class="text-white/80 hover:text-white transition-colors">About</a>
                <a href="/rules" class="text-white/80 hover:text-white transition-colors">Rules</a>
                <a href="/events" class="text-white/80 hover:text-white transition-colors">Events</a>
            </div>

            <div class="flex items-center gap-4">
                @if (\Illuminate\Support\Facades\Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 text-sm font-semibold rounded-md text-white/80 hover:text-white transition-colors duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="hidden sm:block px-4 py-2 text-sm font-semibold rounded-md text-white/80 hover:text-white transition-colors duration-300">
                            Log in
                        </a>
                        @if (\Illuminate\Support\Facades\Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md hover:bg-gray-300 transition-colors duration-300">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <div id="menu-overlay" class="fixed inset-0 bg-black/70 z-30 hidden lg:hidden"></div>

    <aside id="side-menu"
        class="fixed top-0 left-0 w-64 h-full bg-gray-900/90 backdrop-blur-lg shadow-xl z-40 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-xl font-bold font-bebas tracking-wider">MENU</h2>
                <button id="close-btn" class="text-white/80 hover:text-white" aria-label="Close menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col gap-6">
                <a href="/about"
                    class="text-lg text-white/80 hover:text-white hover:pl-2 transition-all duration-300">About</a>
                <a href="/rules"
                    class="text-lg text-white/80 hover:text-white hover:pl-2 transition-all duration-300">Rules</a>
                <a href="/events"
                    class="text-lg text-white/80 hover:text-white hover:pl-2 transition-all duration-300">Events</a>
                <a href="/contact"
                    class="text-lg text-white/80 hover:text-white hover:pl-2 transition-all duration-300">Contact</a>
                <hr class="border-gray-700">
                <a href="{{ route('login') }}"
                    class="sm:hidden text-lg text-white/80 hover:text-white hover:pl-2 transition-all duration-300">Log
                    In</a>
            </nav>
        </div>
    </aside>

    <main class="relative flex items-center justify-center min-h-screen">
        <div class="text-center px-4 animate-fade-in-up">
            <h1 class="text-6xl md:text-8xl font-extrabold font-bebas tracking-tight text-white drop-shadow-lg">
                JOIN THE UPRISING
            </h1>
            <p class="mt-4 text-lg md:text-xl text-white/80 max-w-2xl mx-auto drop-shadow-md">
                A forum for the bold, the brave, and the rebels. Your community awaits.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}"
                    class="inline-block px-8 py-4 text-lg font-bold text-white bg-red-600 rounded-md shadow-lg shadow-red-600/30 hover:bg-red-700 transform transition duration-300 ease-in-out hover:scale-105">
                    Get Started
                </a>
            </div>
        </div>
    </main>

    <div class="bg-black">
        <section class="container mx-auto py-20 px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1" data-scroll-animation="slide-in-left">
                    <h2 class="text-4xl md:text-5xl font-bebas tracking-wider text-red-600 mb-4">OUR CREED</h2>
                    <p class="text-xl text-white/80 mb-6 leading-relaxed">
                        This isn't just a forum; it's a sanctuary for the loud. We are built on raw passion, unfiltered
                        opinions, and the unifying power of heavy music. We embrace the noise, we celebrate the chaos.
                    </p>
                    <a href="/about" class="text-white font-semibold group">
                        <span>Learn More</span>
                        <span class="inline-block transition-transform duration-300 group-hover:translate-x-2">→</span>
                    </a>
                </div>
                <div class="order-1 md:order-2" data-scroll-animation="slide-in-right">
                    <img src="https://imgs.search.brave.com/1C_3PxJLJgFzbI3qb2swaHxJi8h6hlBHqwQ24HU3CT8/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAyLzk0LzY4Lzc0/LzM2MF9GXzI5NDY4/NzQxM19wUUNyYlNB/NEJzcExBTHZBaUhv/cmtsaUx4MjdKN21U/bi5qcGc"
                        alt="Concert crowd" class="rounded-lg shadow-2xl shadow-red-900/20">
                </div>
            </div>
        </section>

        <section class="bg-gray-900 py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-4xl md:text-5xl font-bebas tracking-wider text-white mb-2"
                    data-scroll-animation="fade-in">FROM THE
                    PIT</h2>
                <p class="text-lg text-white/60 mb-12 max-w-2xl mx-auto" data-scroll-animation="fade-in">See what's
                    currently shaking
                    the community ground.</p>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-800 p-8 rounded-lg transform hover:scale-105 transition-transform duration-300"
                        data-scroll-animation="fade-in">
                        <div class="text-red-500 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V4a2 2 0 012-2h8a2 2 0 012 2v4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bebas tracking-wide text-white mb-2">Hot Discussions</h3>
                        <p class="text-white/60">Debate the greatest metal riffs of all time in our most active thread.
                        </p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-lg transform hover:scale-105 transition-transform duration-300"
                        data-scroll-animation="fade-in" style="transition-delay: 150ms;">
                        <div class="text-red-500 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bebas tracking-wide text-white mb-2">Upcoming Gigs</h3>
                        <p class="text-white/60">Check out the community-curated list of local shows and festivals this
                            month.</p>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-lg transform hover:scale-105 transition-transform duration-300"
                        data-scroll-animation="fade-in" style="transition-delay: 300ms;">
                        <div class="text-red-500 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 6l12-3">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bebas tracking-wide text-white mb-2">New Reviews</h3>
                        <p class="text-white/60">Our members' brutal and honest reviews of the latest album drops.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="container mx-auto px-6 text-center" data-scroll-animation="fade-in">
                <h2 class="text-4xl md:text-5xl font-bebas tracking-wider text-white mb-4">Ready to Unleash?</h2>
                <p class="text-lg text-white/60 mb-8 max-w-xl mx-auto">Your people are waiting. Sign up now and become
                    part of the core.</p>
                <a href="{{ route('register') }}"
                    class="inline-block px-8 py-4 text-lg font-bold text-white bg-red-600 rounded-md shadow-lg shadow-red-600/30 hover:bg-red-700 transform transition duration-300 ease-in-out hover:scale-105">
                    Create Your Account
                </a>
            </div>
        </section>

    </div>

    <footer class="bg-gray-900 border-t border-gray-800">
        <div class="container mx-auto py-8 px-6 text-center text-white/40">
            <p>&copy; {{ date('Y') }} Delinquent Community. All Rights Reserved.</p>
            <div class="flex justify-center gap-6 mt-4">
                <a href="#" class="hover:text-white transition-colors">Twitter</a>
                <a href="#" class="hover:text-white transition-colors">Instagram</a>
                <a href="#" class="hover:text-white transition-colors">Discord</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Header scroll effect
            const header = document.getElementById('main-header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            });

            // Mobile menu toggle
            const menuBtn = document.getElementById('menu-btn');
            const closeBtn = document.getElementById('close-btn');
            const sideMenu = document.getElementById('side-menu');
            const menuOverlay = document.getElementById('menu-overlay');

            const toggleMenu = () => {
                sideMenu.classList.toggle('-translate-x-full');
                menuOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            };

            menuBtn.addEventListener('click', toggleMenu);
            closeBtn.addEventListener('click', toggleMenu);
            menuOverlay.addEventListener('click', toggleMenu);

            // Scroll animations
            const animatedElements = document.querySelectorAll('[data-scroll-animation]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            animatedElements.forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>
