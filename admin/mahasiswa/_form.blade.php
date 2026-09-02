@csrf

@if ($errors->any())
    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">NIM</label>
        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Nama Lengkap</label>
        <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Email</label>
        <input type="email" name="email" value="{{ old('email', $mahasiswa->email ?? '') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">
            Password {{ isset($mahasiswa) ? '(kosongkan jika tidak diubah)' : '' }}
        </label>
        <input type="password" name="password" placeholder="{{ isset($mahasiswa) ? '••••••••' : 'Default: mahasiswa123' }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Program Studi</label>
        <input type="text" name="program_studi" value="{{ old('program_studi', $mahasiswa->program_studi ?? '') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Fakultas</label>
        <input type="text" name="fakultas" value="{{ old('fakultas', $mahasiswa->fakultas ?? 'Fakultas Teknologi Elektro dan Informatika Cerdas') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Angkatan</label>
        <input type="number" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Semester</label>
        <input type="number" name="semester" min="1" max="14" value="{{ old('semester', $mahasiswa->semester ?? 1) }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">No. HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 outline-none">
            <option value="">Pilih</option>
            <option value="L" @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') === 'P')>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="text-xs font-medium text-gray-500 mb-1 block">Status</label>
        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 outline-none">
            @foreach (['aktif' => 'Aktif', 'cuti' => 'Cuti', 'lulus' => 'Lulus', 'dropout' => 'Dropout'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $mahasiswa->status ?? 'aktif') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="text-xs font-medium text-gray-500 mb-1 block">Alamat</label>
        <textarea name="alamat" rows="2"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">{{ old('alamat', $mahasiswa->alamat ?? '') }}</textarea>
    </div>
</div>

<div class="flex items-center gap-3 mt-6">
    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold">
        Simpan Data
    </button>
    <a href="{{ route('admin.mahasiswa.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-sm font-medium">
        Batal
    </a>
</div>
