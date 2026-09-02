<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - Admin {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-col w-64 bg-gray-900 text-white shrink-0">
            <div class="px-6 py-6 flex items-center gap-3 border-b border-gray-800">
                <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center font-bold">A</div>
                <div>
                    <p class="font-semibold text-sm leading-tight">{{ config('app.name') }}</p>
                    <p class="text-[11px] text-gray-400">Panel Admin</p>
                </div>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 4v-2a4 4 0 00-3-3.87m-9.5 0a4 4 0 00-3 3.87v2" />
                    </svg>
                    Data Mahasiswa
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:bg-gray-800 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten -->
        <div class="flex-1 min-w-0">
            <!-- Topbar -->
            <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
                    <p class="text-xs text-gray-400">Selamat datang, {{ auth()->user()->name }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </header>

            <main class="p-6">
                @if (session('sukses'))
                    <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm">
                        {{ session('sukses') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
