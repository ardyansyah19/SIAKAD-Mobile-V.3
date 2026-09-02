<x-layouts.admin title="Data Mahasiswa">
    <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
            <form method="GET" class="flex flex-1 gap-2">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari NIM, nama, atau email..."
                    class="w-full sm:max-w-xs px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                <select name="status" class="px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 outline-none">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="cuti" @selected(request('status') === 'cuti')>Cuti</option>
                    <option value="lulus" @selected(request('status') === 'lulus')>Lulus</option>
                    <option value="dropout" @selected(request('status') === 'dropout')>Dropout</option>
                </select>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-sm font-medium">Cari</button>
            </form>
            <a href="{{ route('admin.mahasiswa.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mahasiswa
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-400 text-xs border-b border-gray-100">
                        <th class="pb-3 font-medium">NIM</th>
                        <th class="pb-3 font-medium">Nama</th>
                        <th class="pb-3 font-medium">Program Studi</th>
                        <th class="pb-3 font-medium">Angkatan</th>
                        <th class="pb-3 font-medium">Semester</th>
                        <th class="pb-3 font-medium">Status</th>
                        <th class="pb-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $mhs)
                        <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50/60">
                            <td class="py-3 text-gray-700">{{ $mhs->nim }}</td>
                            <td class="py-3 text-gray-800 font-medium">{{ $mhs->nama }}</td>
                            <td class="py-3 text-gray-500">{{ $mhs->program_studi }}</td>
                            <td class="py-3 text-gray-500">{{ $mhs->angkatan }}</td>
                            <td class="py-3 text-gray-500">{{ $mhs->semester }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-[11px] font-medium
                                    {{ match($mhs->status) {
                                        'aktif' => 'bg-emerald-50 text-emerald-600',
                                        'cuti' => 'bg-amber-50 text-amber-600',
                                        'lulus' => 'bg-indigo-50 text-indigo-600',
                                        default => 'bg-red-50 text-red-600',
                                    } }}">
                                    {{ ucfirst($mhs->status) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs) }}"
                                        class="p-2 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $mhs) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus data {{ $mhs->nama }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-8 text-center text-gray-400">Tidak ada data mahasiswa ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            {{ $mahasiswa->links() }}
        </div>
    </div>
</x-layouts.admin>
