<x-layouts.mobile title="Profil">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-16 rounded-b-[2rem] text-center relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>

        @if ($mahasiswa->foto)
            <img src="{{ asset('storage/'.$mahasiswa->foto) }}" alt="{{ $user->name }}"
                class="w-20 h-20 rounded-2xl object-cover mx-auto relative border-2 border-white/40">
        @else
            <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur mx-auto flex items-center justify-center text-white text-2xl font-bold relative">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
        <h1 class="text-white font-bold mt-3 relative">{{ $user->name }}</h1>
        <p class="text-indigo-100 text-xs relative">{{ $mahasiswa->nim ?? '-' }}</p>
    </div>

    <div class="px-5 -mt-10 relative space-y-3">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 space-y-4 transition-colors">
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Program Studi</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $mahasiswa->program_studi ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Fakultas</span>
                <span class="font-medium text-gray-800 dark:text-gray-100 text-right w-2/3">{{ $mahasiswa->fakultas ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Angkatan</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $mahasiswa->angkatan ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Semester</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $mahasiswa->semester ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Email</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $user->email }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">No. HP</span>
                <span class="font-medium text-gray-800 dark:text-gray-100">{{ $mahasiswa->no_hp ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Alamat</span>
                <span class="font-medium text-gray-800 dark:text-gray-100 text-right w-2/3">{{ $mahasiswa->alamat ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm items-center">
                <span class="text-gray-400">Status</span>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium
                    {{ $mahasiswa->status === 'aktif' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-300' }}">
                    {{ ucfirst($mahasiswa->status ?? '-') }}
                </span>
            </div>
        </div>

        <a href="{{ route('mahasiswa.profil.edit') }}" class="flex items-center justify-center gap-2 w-full bg-indigo-600 text-white font-semibold py-3 rounded-xl text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Profil
        </a>

        <!-- Toggle Mode Gelap -->
        <div x-data="{ dark: localStorage.getItem('siakad-dark') === '1' }"
            x-init="$watch('dark', value => { document.documentElement.classList.toggle('dark', value); localStorage.setItem('siakad-dark', value ? '1' : '0'); })"
            class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 transition-colors">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 1012 21a8.997 8.997 0 008.354-5.646z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Mode Gelap</span>
            </div>
            <button type="button" @click="dark = !dark"
                :class="dark ? 'bg-indigo-600' : 'bg-gray-200'"
                class="w-11 h-6 rounded-full relative transition-colors">
                <span :class="dark ? 'translate-x-5' : 'translate-x-1'"
                    class="absolute top-1 w-4 h-4 bg-white rounded-full transition-transform"></span>
            </button>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 font-semibold py-3 rounded-xl text-sm">
                Keluar Akun
            </button>
        </form>
    </div>
</x-layouts.mobile>
