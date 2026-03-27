<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Nurse Shift App') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-slate-100 text-slate-800">

    @auth
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex min-h-16 items-center justify-between py-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-600 text-white font-bold shadow">
                        NS
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Nurse Shift App</p>
                        <p class="text-xs text-slate-500">Manage your own shifts and leave</p>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('dashboard') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('calendar.index') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('calendar.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Calendar
                    </a>

                    <a href="{{ route('schedules.index') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('schedules.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        My Schedule
                    </a>

                    <a href="{{ route('schedules.create') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('schedules.create') ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Add Schedule
                    </a>

                    <a href="{{ route('reports.weekly') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Weekly Report
                    </a>

                    <a href="{{ route('profile.index') }}"
                        class="rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Profile
                    </a>

                    <div class="ml-3 flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 lg:hidden">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-600 text-sm font-bold text-white shadow">
                            TN
                        </div>
                        <div class="leading-tight">
                            <p class="text-sm font-semibold text-slate-900">Thiran Naleendra</p>
                            <div class="flex items-center gap-2">
                                <p class="text-xs text-slate-500">Developer & Owner</p>
                                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">
                                    Owner
                                </span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button class="rounded-xl bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>

                <button id="mobileMenuBtn"
                    class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white p-2 text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <div id="mobileMenu" class="hidden border-t border-slate-200 py-4 lg:hidden">
                <div class="mb-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-sm font-bold text-white shadow">
                            TN
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Thiran Naleendra</p>
                            <p class="text-xs text-slate-500">Developer & Owner</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('dashboard') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('calendar.index') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('calendar.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Calendar
                    </a>

                    <a href="{{ route('schedules.index') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('schedules.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        My Schedule
                    </a>

                    <a href="{{ route('schedules.create') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('schedules.create') ? 'bg-emerald-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Add Schedule
                    </a>

                    <a href="{{ route('reports.weekly') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Weekly Report
                    </a>

                    <a href="{{ route('profile.index') }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="mt-2 w-full rounded-xl bg-red-500 px-4 py-3 text-sm font-semibold text-white hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    @endauth

    <main class="flex-1 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

   <footer class="border-t border-slate-200 bg-white py-4">
        <div class="mx-auto max-w-7xl px-4 text-center text-sm text-slate-500 sm:px-6 lg:px-8">
            漏 {{ date('Y') }} Nurse Shift App 路 Developed by
            <span class="font-semibold text-slate-700">Thiran Naleendra</span>
            路 Developer & Owner
        </div>
    </footer>

    @auth
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    @endauth
</body>

</html>