<x-layouts.mobile title="Kartu Hasil Studi">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-16 rounded-b-[2rem] relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="flex items-center gap-3 relative">
            <a href="{{ route('mahasiswa.beranda') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-white text-lg font-bold">Kartu Hasil Studi</h1>
        </div>
    </div>

    <!-- Kartu IPK -->
    <div class="px-5 -mt-10 relative">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 grid grid-cols-2 gap-3 text-center transition-colors">
            <div>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($ipk, 2) }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">IPK Kumulatif</p>
            </div>
            <div class="border-l border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $sksTempuh }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Total SKS Lulus</p>
            </div>
        </div>
    </div>

    @if ($riwayatSemester->isEmpty())
        <div class="px-5 mt-8 text-center">
            <p class="text-sm text-gray-400">Belum ada riwayat nilai semester.</p>
        </div>
    @else
        <div x-data="{ semester: {{ $semesterDipilih }} }" class="px-5 mt-6">
            <!-- Chip semester -->
            <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
                @foreach ($riwayatSemester as $semKe => $data)
                    <button type="button" @click="semester = {{ $semKe }}"
                        :class="semester === {{ $semKe }} ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-300'"
                        class="shrink-0 px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-colors">
                        Semester {{ $semKe }}
                    </button>
                @endforeach
            </div>

            @foreach ($riwayatSemester as $semKe => $data)
                <div x-show="semester === {{ $semKe }}" x-cloak class="mt-4 space-y-3">
                    <div class="flex items-center justify-between bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl px-4 py-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $data['tahun_ajaran'] }}</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $data['sks'] }} SKS ditempuh</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($data['ips'], 2) }}</p>
                            <p class="text-[10px] text-gray-400">IPS</p>
                        </div>
                    </div>

                    @foreach ($data['mata_kuliah'] as $krs)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex items-center gap-3 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $krs->mataKuliah->nama_mk }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $krs->mataKuliah->kode_mk }} · {{ $krs->mataKuliah->sks }} SKS</p>
                            </div>
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0
                                {{ match(true) {
                                    in_array($krs->nilai_huruf, ['A', 'AB']) => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                                    in_array($krs->nilai_huruf, ['B', 'BC']) => 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                                    default => 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400',
                                } }}">
                                {{ $krs->nilai_huruf }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.mobile>
