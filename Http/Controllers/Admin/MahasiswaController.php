<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    /**
     * Tampilkan daftar mahasiswa (dengan pencarian & filter status).
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::query();

        if ($request->filled('cari')) {
            $keyword = $request->input('cari');
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nim', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $mahasiswa = $query->latest()->paginate(10)->withQueryString();

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Form tambah mahasiswa baru.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Simpan mahasiswa baru sekaligus akun login-nya.
     */
    public function store(Request $request)
    {
        $data = $this->validasi($request);

        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'] ?? 'mahasiswa123'),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'program_studi' => $data['program_studi'],
            'fakultas' => $data['fakultas'] ?? 'Fakultas Teknologi Elektro dan Informatika Cerdas',
            'angkatan' => $data['angkatan'],
            'semester' => $data['semester'],
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.mahasiswa.index')
            ->with('sukses', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu mahasiswa.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Form edit mahasiswa.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update data mahasiswa.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $this->validasi($request, $mahasiswa->id);

        $mahasiswa->update([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'program_studi' => $data['program_studi'],
            'fakultas' => $data['fakultas'] ?? $mahasiswa->fakultas,
            'angkatan' => $data['angkatan'],
            'semester' => $data['semester'],
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'status' => $data['status'],
        ]);

        if ($mahasiswa->user) {
            $mahasiswa->user->update([
                'name' => $data['nama'],
                'email' => $data['email'],
            ]);

            if (! empty($data['password'])) {
                $mahasiswa->user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }
        }

        return redirect()->route('admin.mahasiswa.index')
            ->with('sukses', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Hapus data mahasiswa beserta akun login-nya.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $user = $mahasiswa->user;
        $mahasiswa->delete();
        $user?->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('sukses', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * Aturan validasi form tambah/edit mahasiswa.
     */
    private function validasi(Request $request, $idMahasiswa = null): array
    {
        return $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswas', 'nim')->ignore($idMahasiswa)],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('mahasiswas', 'email')->ignore($idMahasiswa)],
            'program_studi' => ['required', 'string', 'max:255'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['required', 'digits:4', 'integer', 'min:2000'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'status' => ['required', 'in:aktif,cuti,lulus,dropout'],
            'password' => ['nullable', 'string', 'min:6'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'program_studi.required' => 'Program studi wajib diisi.',
            'angkatan.required' => 'Angkatan wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);
    }
}
