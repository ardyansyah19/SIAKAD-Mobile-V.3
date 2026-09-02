<x-layouts.admin title="Detail Mahasiswa">
    <div class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ $mahasiswa->nama }}</h2>
                <p class="text-sm text-gray-400">{{ $mahasiswa->nim }}</p>
            </div>
            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold">Edit</a>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-400 text-xs">Program Studi</p><p class="font-medium text-gray-800">{{ $mahasiswa->program_studi }}</p></div>
            <div><p class="text-gray-400 text-xs">Fakultas</p><p class="font-medium text-gray-800">{{ $mahasiswa->fakultas }}</p></div>
            <div><p class="text-gray-400 text-xs">Angkatan</p><p class="font-medium text-gray-800">{{ $mahasiswa->angkatan }}</p></div>
            <div><p class="text-gray-400 text-xs">Semester</p><p class="font-medium text-gray-800">{{ $mahasiswa->semester }}</p></div>
            <div><p class="text-gray-400 text-xs">Email</p><p class="font-medium text-gray-800">{{ $mahasiswa->email }}</p></div>
            <div><p class="text-gray-400 text-xs">No. HP</p><p class="font-medium text-gray-800">{{ $mahasiswa->no_hp ?? '-' }}</p></div>
            <div><p class="text-gray-400 text-xs">Status</p><p class="font-medium text-gray-800">{{ ucfirst($mahasiswa->status) }}</p></div>
            <div class="col-span-2"><p class="text-gray-400 text-xs">Alamat</p><p class="font-medium text-gray-800">{{ $mahasiswa->alamat ?? '-' }}</p></div>
        </div>

        <a href="{{ route('admin.mahasiswa.index') }}" class="inline-block mt-6 text-sm text-indigo-600 font-medium">&larr; Kembali ke daftar</a>
    </div>
</x-layouts.admin>
