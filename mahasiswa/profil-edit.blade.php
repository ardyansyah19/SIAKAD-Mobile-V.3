<x-layouts.mobile title="Edit Profil">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-14 rounded-b-[2rem] relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="flex items-center gap-3 relative">
            <a href="{{ route('mahasiswa.profil') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-white text-lg font-bold">Edit Profil</h1>
        </div>
    </div>

    <div class="px-5 -mt-8 relative">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 transition-colors">
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/30 text-red-600 dark:text-red-400 text-sm space-y-1">
                    @foreach ($errors->all() as $pesan)
                        <p>{{ $pesan }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.profil.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-4">
                    @if ($mahasiswa->foto)
                        <img src="{{ asset('storage/'.$mahasiswa->foto) }}" alt="Foto profil" class="w-14 h-14 rounded-xl object-cover">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 block">Foto Profil</label>
                        <input type="file" name="foto" accept="image/*"
                            class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-600 dark:file:bg-indigo-500/10 dark:file:text-indigo-400">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 block">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}" placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 block">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 block">Alamat</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat domisili"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                </div>

                <p class="text-[11px] text-gray-400">NIM, nama, email, dan data akademik lain hanya bisa diubah oleh admin.</p>

                <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-xl text-sm">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-layouts.mobile>
