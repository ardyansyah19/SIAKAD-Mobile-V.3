<x-layouts.mobile title="Pengisian KRS">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-16 rounded-b-[2rem] relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="flex items-center gap-3 relative mb-4">
            <a href="{{ route('mahasiswa.beranda') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-white text-lg font-bold">Kartu Rencana Studi</h1>
                <p class="text-indigo-100 text-xs">{{ $tahunAjaranAktif }}</p>
            </div>
        </div>
    </div>

    <!-- Meter SKS -->
    <div class="px-5 -mt-10 relative">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-gray-400">Total SKS diambil</span>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $totalSks }} / {{ $maksSks }} SKS</span>
            </div>
            <div class="w-full h-2.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-indigo-600 rounded-full transition-all" style="width: {{ min(100, round($totalSks / $maksSks * 100)) }}%"></div>
            </div>
        </div>
    </div>

    <div x-data="{ tab: 'diambil' }" class="px-5 mt-6">
        <div class="flex gap-2 mb-4">
            <button type="button" @click="tab = 'diambil'"
                :class="tab === 'diambil' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300'"
                class="flex-1 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                MK Diambil ({{ $krsAktif->count() }})
            </button>
            <button type="button" @click="tab = 'tersedia'"
                :class="tab === 'tersedia' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300'"
                class="flex-1 py-2.5 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                Tambah MK ({{ $mataKuliahTersedia->count() }})
            </button>
        </div>

        <!-- MK yang sudah diambil -->
        <div x-show="tab === 'diambil'" x-cloak class="space-y-3">
            @forelse ($krsAktif as $krs)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex items-center gap-3 transition-colors">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $krs->mataKuliah->nama_mk }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $krs->mataKuliah->hari }} · {{ $krs->mataKuliah->jam }} · {{ $krs->mataKuliah->ruang }}</p>
                        <span class="inline-block mt-1.5 text-[11px] bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-full">{{ $krs->mataKuliah->sks }} SKS</span>
                    </div>
                    <form method="POST" action="{{ route('mahasiswa.krs.destroy', $krs) }}" onsubmit="return confirm('Batalkan mata kuliah ini dari KRS?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-500 dark:text-red-400 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-8">Belum ada mata kuliah yang diambil semester ini.</p>
            @endforelse
        </div>

        <!-- MK tersedia -->
        <div x-show="tab === 'tersedia'" x-cloak class="space-y-3">
            @forelse ($mataKuliahTersedia as $mk)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex items-center gap-3 transition-colors">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $mk->nama_mk }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $mk->hari }} · {{ $mk->jam }} · {{ $mk->ruang }} · {{ $mk->dosen }}</p>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <span class="text-[11px] bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-0.5 rounded-full">{{ $mk->sks }} SKS</span>
                            <span class="text-[11px] bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-0.5 rounded-full">Semester {{ $mk->semester }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('mahasiswa.krs.store') }}">
                        @csrf
                        <input type="hidden" name="mata_kuliah_id" value="{{ $mk->id }}">
                        <button type="submit" class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-8">Tidak ada mata kuliah lain yang tersedia.</p>
            @endforelse
        </div>
    </div>
</x-layouts.mobile>
