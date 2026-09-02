<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Beranda' }} - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' };</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
    <script>
        // Terapkan preferensi mode gelap sedini mungkin agar tidak "berkedip".
        if (localStorage.getItem('siakad-dark') === '1') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-950 transition-colors">
    <!-- Bingkai ala aplikasi mobile -->
    <div class="max-w-md mx-auto bg-gray-50 dark:bg-gray-900 min-h-screen relative shadow-2xl pb-24 transition-colors">

        <!-- Toast notifikasi (sukses / gagal) -->
        @if (session('sukses') || session('gagal'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
                class="fixed top-4 inset-x-4 max-w-md mx-auto z-50">
                <div class="flex items-start gap-3 rounded-2xl shadow-lg p-4 text-sm font-medium
                    {{ session('sukses') ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white' }}">
                    <span>{{ session('sukses') ?? session('gagal') }}</span>
                </div>
            </div>
        @endif

        {{ $slot }}

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 inset-x-0 max-w-md mx-auto bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 rounded-t-3xl shadow-[0_-4px_20px_rgba(0,0,0,0.06)] transition-colors">
            <div class="flex items-center justify-around py-3">
                <a href="{{ route('mahasiswa.beranda') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('mahasiswa.beranda') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-[11px] font-medium">Beranda</span>
                </a>
                <a href="{{ route('mahasiswa.khs') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('mahasiswa.khs') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-[11px] font-medium">Nilai</span>
                </a>
                <a href="{{ route('mahasiswa.jadwal') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('mahasiswa.jadwal') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-[11px] font-medium">Jadwal</span>
                </a>
                <a href="{{ route('mahasiswa.krs') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('mahasiswa.krs') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h4m0 0l-3-3m3 3l-3 3M4 7h16M4 7a2 2 0 002 2h12a2 2 0 002-2M4 7a2 2 0 012-2h12a2 2 0 012 2" />
                    </svg>
                    <span class="text-[11px] font-medium">KRS</span>
                </a>
                <a href="{{ route('mahasiswa.profil') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('mahasiswa.profil*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 dark:text-gray-500' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-[11px] font-medium">Profil</span>
                </a>
            </div>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
