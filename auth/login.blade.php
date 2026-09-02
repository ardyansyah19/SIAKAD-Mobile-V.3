<x-layouts.guest title="Masuk">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 pt-10 pb-16 text-center relative">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 class="text-white text-xl font-bold">{{ config('app.name') }}</h1>
                <p class="text-indigo-100 text-sm mt-1">Portal Akademik Mahasiswa</p>
            </div>

            <div class="px-8 -mt-8 pb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-gray-800 font-semibold text-lg mb-1">Selamat Datang 👋</h2>
                    <p class="text-gray-400 text-sm mb-6">Silakan masuk untuk melanjutkan</p>

                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="nama@kampus.ac.id"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-gray-500 mb-1 block">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" name="password" required
                                    placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none text-sm transition">
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 text-gray-500">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 rounded-xl shadow-lg shadow-indigo-200 hover:opacity-90 active:scale-[.98] transition">
                            Masuk
                        </button>
                    </form>

                    <div class="mt-6 pt-5 border-t border-gray-100 text-center text-xs text-gray-400 space-y-1">
                        <p>Akun Demo Admin: <span class="font-medium text-gray-600">admin@kampus.ac.id / admin123</span></p>
                        <p>Akun Demo Mahasiswa: <span class="font-medium text-gray-600">riko@kampus.ac.id / mahasiswa123</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
