<x-layouts.admin title="Dashboard">
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</p>
            <p class="text-xs text-gray-400 mt-1">Total Mahasiswa</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalAktif }}</p>
            <p class="text-xs text-gray-400 mt-1">Mahasiswa Aktif</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalCuti }}</p>
            <p class="text-xs text-gray-400 mt-1">Sedang Cuti</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalLulus }}</p>
            <p class="text-xs text-gray-400 mt-1">Telah Lulus</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Mahasiswa per Prodi -->
        <div class="bg-white rounded-2xl shadow-sm p-5 lg:col-span-1">
            <h2 class="font-semibold text-gray-800 mb-4 text-sm">Mahasiswa per Program Studi</h2>
            <div class="space-y-3">
                @forelse ($perProdi as $prodi)
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-600">{{ $prodi->program_studi }}</span>
                            <span class="text-gray-400">{{ $prodi->jumlah }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $totalMahasiswa > 0 ? ($prodi->jumlah / $totalMahasiswa * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada data.</p>
                @endforelse
            </div>
        </div>

        <!-- Mahasiswa Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-800 text-sm">Mahasiswa Terbaru Ditambahkan</h2>
                <a href="{{ route('admin.mahasiswa.index') }}" class="text-xs text-indigo-600 font-medium">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 text-xs border-b border-gray-100">
                            <th class="pb-2 font-medium">NIM</th>
                            <th class="pb-2 font-medium">Nama</th>
                            <th class="pb-2 font-medium">Prodi</th>
                            <th class="pb-2 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswaTerbaru as $mhs)
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-3 text-gray-700">{{ $mhs->nim }}</td>
                                <td class="py-3 text-gray-700 font-medium">{{ $mhs->nama }}</td>
                                <td class="py-3 text-gray-500">{{ $mhs->program_studi }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded-full text-[11px] font-medium
                                        {{ $mhs->status === 'aktif' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                                        {{ ucfirst($mhs->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-gray-400">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
