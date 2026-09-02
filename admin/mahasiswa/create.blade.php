<x-layouts.admin title="Tambah Mahasiswa">
    <div class="bg-white rounded-2xl shadow-sm p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
            @include('admin.mahasiswa._form')
        </form>
    </div>
</x-layouts.admin>
