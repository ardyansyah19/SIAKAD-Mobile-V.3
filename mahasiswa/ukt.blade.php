<x-layouts.mobile title="Pembayaran UKT">
    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 dark:from-indigo-800 dark:to-purple-900 px-5 pt-8 pb-16 rounded-b-[2rem] relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="flex items-center gap-3 relative">
            <a href="{{ route('mahasiswa.beranda') }}" class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center backdrop-blur">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-white text-lg font-bold">Pembayaran UKT</h1>
        </div>
    </div>

    <div class="px-5 -mt-10 relative space-y-4">
        <!-- Tagihan berjalan -->
        @if ($tagihanBerjalan)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 transition-colors" x-data="{ bayarOpen: false }">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">Semester {{ $tagihanBerjalan->semester_ke }} · {{ $tagihanBerjalan->tahun_ajaran }}</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-gray-100 mt-1">Rp {{ number_format($tagihanBerjalan->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">Belum Bayar</span>
                </div>
                <button type="button" @click="bayarOpen = true" class="w-full mt-4 bg-indigo-600 text-white font-semibold py-3 rounded-xl text-sm">
                    Bayar Sekarang
                </button>

                <!-- Modal metode pembayaran -->
                <div x-show="bayarOpen" x-cloak class="fixed inset-0 bg-black/40 flex items-end justify-center z-50" style="display:none;">
                    <div @click.outside="bayarOpen = false" class="bg-white dark:bg-gray-800 w-full max-w-md rounded-t-3xl p-6">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1">Pilih Metode Pembayaran</h3>
                        <p class="text-xs text-gray-400 mb-4">Simulasi pembayaran demo — tidak ada transaksi nyata.</p>
                        <form method="POST" action="{{ route('mahasiswa.ukt.bayar', $tagihanBerjalan) }}" class="space-y-2">
                            @csrf
                            @foreach (['Transfer Bank', 'Virtual Account', 'E-Wallet'] as $metode)
                                <label class="flex items-center gap-3 border border-gray-200 dark:border-gray-600 rounded-xl p-3 cursor-pointer">
                                    <input type="radio" name="metode" value="{{ $metode }}" {{ $loop->first ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-200">{{ $metode }}</span>
                                </label>
                            @endforeach
                            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-xl text-sm mt-2">
                                Konfirmasi Pembayaran
                            </button>
                            <button type="button" @click="bayarOpen = false" class="w-full text-gray-400 text-sm py-2">
                                Batal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-5 text-center transition-colors">
                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Semua tagihan UKT sudah lunas 🎉</p>
            </div>
        @endif

        <!-- Ringkasan -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex items-center justify-between transition-colors">
            <span class="text-xs text-gray-400">Total sudah dibayar</span>
            <span class="text-sm font-bold text-gray-800 dark:text-gray-100">Rp {{ number_format($totalLunas, 0, ',', '.') }}</span>
        </div>

        <!-- Riwayat -->
        <div>
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Riwayat Pembayaran</h2>
            <div class="space-y-3">
                @foreach ($riwayat as $bayar)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-4 flex items-center gap-3 transition-colors">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                            {{ $bayar->status === 'lunas' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">Semester {{ $bayar->semester_ke }} · {{ $bayar->tahun_ajaran }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}
                                @if ($bayar->tanggal_bayar)
                                    · {{ $bayar->tanggal_bayar->translatedFormat('d M Y') }}
                                @endif
                            </p>
                        </div>
                        <span class="text-[11px] font-medium px-2 py-1 rounded-full
                            {{ $bayar->status === 'lunas' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400' }}">
                            {{ $bayar->status === 'lunas' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.mobile>
