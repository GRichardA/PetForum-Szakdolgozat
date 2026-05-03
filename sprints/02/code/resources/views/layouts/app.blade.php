<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop - @yield('title', 'Közösség')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Alap stílus a navigációs linkekhez */
        .nav-link-base {
            @apply px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out;
        }
        /* Dark mode overrides (basic) */
        /* Default text on dark backgrounds should be white for contrast */
        .dark body { background-color: #0f172a; color: #ffffff; }
        .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700, .dark .text-gray-600 { color: #ffffff !important; }
        .dark .text-gray-500 { color: #c7c7c7 !important; }
        .dark .border-gray-100 { border-color: #1f2937 !important; }
        .dark .bg-gray-50 { background-color: #071024 !important; }

        /* EXCEPTION: only form controls should keep a light background in dark mode
           so their placeholder/value remains readable. Do NOT override generic
           `.bg-white` components (navbars/cards/etc) — they should stay dark. */
        .dark .bg-white { background-color: #0b1220 !important; color: #e5e7eb !important; }

        /* Keep inputs/selects/textarea inside forms light with dark text */
        .dark form input, .dark form textarea, .dark form select,
        .dark form input[type="text"], .dark form input[type="email"], .dark form input[type="password"],
        .dark form input[type="datetime-local"], .dark form .form-input, .dark form .form-control {
            background-color: #ffffff !important;
            color: #000000 !important;
            caret-color: #000000 !important;
            border-color: #d1d5db !important;
        }

        /* Force black text for admin card links in dark mode */
        .dark a[href*="admin"] strong, .dark a[href*="admin"] small {
            color: #000000 !important;
        }
        .dark a[href*="admin"] {
            color: #000000 !important;
        }
        .dark a[href*="admin"] * {
            color: inherit !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white shadow-sm mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('events.index') }}" class="text-2xl font-bold text-indigo-600">
                        🐶 PetShop
                    </a>
                </div>
                
                {{-- NAVIGÁCIÓS ÉS AUTH BLOKK --}}
                <div class="flex items-center space-x-4">

                    {{-- Theme toggle --}}
                    <button id="theme-toggle" class="p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none" title="Téma váltás">
                        <!-- Sun icon for light mode -->
                        <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.76 4.84l-1.8-1.79L3.17 4.83l1.79 1.79 1.8-1.78zM1 11h3v2H1v-2zm9-9h2v3h-2V2zm7.64 2.83l-1.79 1.79 1.79 1.79 1.79-1.79-1.79-1.79zM17 11h3v2h-3v-2zM10 18h2v3h-2v-3zm4.24-1.16l1.79 1.79 1.79-1.79-1.79-1.79-1.79 1.79zM6.76 19.16l1.79-1.79-1.79-1.79-1.79 1.79 1.79 1.79zM12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <!-- Moon icon for dark mode -->
                        <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor"><path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z"/></svg>
                    </button>
                    
                    {{-- Fő navigációs linkek (Mindig látható) --}}
                    <a href="{{ route('events.index') }}" 
                       class="nav-link-base {{ Request::routeIs('events.index') && !Request::routeIs('events.myEvents') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }}">
                        Összes Esemény
                    </a>

                    @auth
                        {{-- 💡 ÚJ LINK: SAJÁT ESEMÉNYEIM (Csak bejelentkezett felhasználóknak) 💡 --}}
                        <a href="{{ route('events.myEvents') }}" 
                           class="nav-link-base {{ Request::routeIs('events.myEvents') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }}">
                            Saját Eseményeim
                        </a>
                        
                        {{-- Akció gomb --}}
                        <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            + Új Esemény
                        </a>

                        {{-- Felhasználói Menü/Kijelentkezés --}}
                        <div class="relative" tabindex="0">
                            <button id="user-menu-button" aria-haspopup="true" aria-expanded="false" class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition duration-150 ease-in-out p-2 rounded-md hover:bg-gray-100">
                                {{ Auth::user()->name ?? 'Profil' }}
                                <svg class="ml-1 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="user-menu" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 hidden z-50" aria-labelledby="user-menu-button">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil szerkesztése</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kijelentkezés</button>
                                </form>
                            </div>
                        </div>

                        <script>
                            // Kicsi, egyszerű JS, hogy a menü kattintásra nyíljon, és ne tűnjön el egérmozgatáskor.
                            (function () {
                                var btn = document.getElementById('user-menu-button');
                                var menu = document.getElementById('user-menu');
                                if (!btn || !menu) return;

                                // Toggle a menü láthatóságát kattintásra
                                btn.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    var isHidden = menu.classList.contains('hidden');
                                    if (isHidden) {
                                        menu.classList.remove('hidden');
                                        btn.setAttribute('aria-expanded', 'true');
                                    } else {
                                        menu.classList.add('hidden');
                                        btn.setAttribute('aria-expanded', 'false');
                                    }
                                });

                                // Bezárás, ha a felhasználó máshova kattint
                                document.addEventListener('click', function (e) {
                                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                                        if (!menu.classList.contains('hidden')) {
                                            menu.classList.add('hidden');
                                            btn.setAttribute('aria-expanded', 'false');
                                        }
                                    }
                                });
                            })();
                        </script>

                    @else
                        {{-- 2. VENDÉG FELHASZNÁLÓKNAK (NINCS BEJELENTKEZVE) --}}
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-medium">
                            Bejelentkezés
                        </a>
                        <a href="{{ route('register') }}" class="px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                            Regisztráció
                        </a>
                    @endauth
                </div>
                {{-- END NAVIGÁCIÓS/AUTH BLOKK --}}
            </div>
        </div>
    </nav>
        
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-12 py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} PetShop Project. Minden jog fenntartva.
    </footer>

    <script>
        // Theme toggle: store preference in localStorage and apply .dark on <html>
        (function () {
            var themeToggle = document.getElementById('theme-toggle');
            var lightIcon = document.getElementById('theme-toggle-light-icon');
            var darkIcon = document.getElementById('theme-toggle-dark-icon');

            function applyTheme(theme) {
                var html = document.documentElement;
                if (theme === 'dark') {
                    html.classList.add('dark');
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                } else {
                    html.classList.remove('dark');
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                }
            }

            // Initialize from localStorage or system preference
            var saved = localStorage.getItem('theme');
            if (saved) {
                applyTheme(saved);
            } else {
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                applyTheme(prefersDark ? 'dark' : 'light');
            }

            if (!themeToggle) return;
            themeToggle.addEventListener('click', function () {
                var isDark = document.documentElement.classList.contains('dark');
                var next = isDark ? 'light' : 'dark';
                localStorage.setItem('theme', next);
                applyTheme(next);
            });
        })();
    </script>

    <script>
        // Password show/hide toggle: finds buttons with data-target attribute
        (function () {
            function setupToggle(btn) {
                var targetId = btn.getAttribute('data-target');
                if (!targetId) return;
                var input = document.getElementById(targetId);
                if (!input) return;

                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (input.type === 'password') {
                        input.type = 'text';
                        btn.setAttribute('aria-pressed', 'true');
                    } else {
                        input.type = 'password';
                        btn.setAttribute('aria-pressed', 'false');
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                var buttons = document.querySelectorAll('.password-toggle-btn');
                buttons.forEach(setupToggle);
            });
        })();
    </script>
    <style>
        /* Password visibility toggle button inside input wrappers */
        .password-toggle-btn {
            background: transparent;
            border: none;
            padding: 0.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #6b7280; /* gray-500 */
        }
        .password-toggle-btn:hover { color: #374151; }
        .password-input-wrap { position: relative; }
        .password-toggle-btn { position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); }
    </style>
</body>
</html>