<x-layouts.mobile title="Jadwal Kuliah">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-14 rounded-b-[2rem] relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="flex items-center gap-3 relative mb-4">
            <a href="{{ route('mahasiswa.beranda') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-white text-lg font-bold">Jadwal Kuliah</h1>
                <p class="text-indigo-100 text-xs">{{ $tahunAjaranAktif ?? 'Belum ada KRS aktif' }}</p>
            </div>
        </div>
        <div class="flex gap-2 relative">
            <span class="bg-white/20 text-white text-xs px-3 py-1.5 rounded-full">{{ $totalMataKuliah }} Mata Kuliah</span>
            <span class="bg-white/20 text-white text-xs px-3 py-1.5 rounded-full">{{ $totalSks }} SKS</span>
        </div>
    </div>

    <div x-data="{ hari: '{{ $hariIniIndo && $jadwalPerHari->has($hariIniIndo) ? $hariIniIndo : ($jadwalPerHari->keys()->first() ?? 'Senin') }}' }" class="px-5 -mt-6 relative">
        <!-- Tab hari -->
        <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
            @foreach ($urutanHari as $hari)
                @if ($hari !== 'Minggu')
                    <button type="button" @click="hari = '{{ $hari }}'"
                        :class="hari === '{{ $hari }}' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300'"
                        class="shrink-0 px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-colors relative">
                        {{ substr($hari, 0, 3) }}
                        @if ($hari === $hariIniIndo)
                            <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Isi jadwal per hari -->
        <div class="mt-4 space-y-3 pb-2">
            @forelse ($jadwalPerHari as $hari => $daftar)
                <div x-show="hari === '{{ $hari }}'" x-cloak class="space-y-3">
                    @foreach ($daftar as $krs)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex gap-3 transition-colors">
                            <div class="flex flex-col items-center shrink-0 w-16 text-center">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ substr($krs->mataKuliah->jam_mulai, 0, 5) }}</span>
                                <span class="w-px flex-1 bg-gray-200 dark:bg-gray-600 my-1"></span>
                                <span class="text-[10px] text-gray-400">{{ substr($krs->mataKuliah->jam_selesai, 0, 5) }}</span>
                            </div>
                            <div class="flex-1 min-w-0 border-l border-gray-100 dark:border-gray-700 pl-3">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $krs->mataKuliah->nama_mk }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $krs->mataKuliah->dosen }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-[11px] bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-0.5 rounded-full">{{ $krs->mataKuliah->ruang }}</span>
                                    <span class="text-[11px] bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-0.5 rounded-full">{{ $krs->mataKuliah->sks }} SKS</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
            @endforelse

            @foreach ($urutanHari as $hari)
                @if ($hari !== 'Minggu' && ! $jadwalPerHari->has($hari))
                    <div x-show="hari === '{{ $hari }}'" x-cloak class="text-center py-10">
                        <p class="text-sm text-gray-400">Tidak ada kuliah di hari {{ $hari }}.</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-layouts.mobile>
