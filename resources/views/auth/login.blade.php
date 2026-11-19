<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Kas Kelas SMK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-sm">
        {{-- Header Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex w-12 h-12 bg-indigo-600 rounded-xl items-center justify-center text-white mb-3 shadow-md shadow-indigo-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-800">Kas Kelas SMK</h1>
            <p class="text-xs text-gray-500 mt-1">Sistem Pengelolaan Uang Kas & Keuangan Kelas</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="text-base font-semibold text-gray-800 mb-5">Masuk ke Sistem</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', 'bendahara@kas.com') }}" required autofocus
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors @error('email') border-red-400 @enderror"
                           placeholder="nama@kas.com">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">Password</label>
                    <input type="password" name="password" value="password" required
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors @error('password') border-red-400 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium py-2.5 rounded-lg text-sm transition-colors shadow-sm">
                    Masuk
                </button>
            </form>

            {{-- Demo Hint --}}
            <div class="mt-6 pt-5 border-t border-gray-100 text-xs text-gray-400 text-center">
                <p class="font-medium text-gray-600 mb-1">Akun Demo Siap Pakai:</p>
                <p>Email: <code class="text-indigo-600 font-mono">bendahara@kas.com</code></p>
                <p>Password: <code class="text-indigo-600 font-mono">password</code></p>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Kas Kelas SMK &copy; {{ date('Y') }}
        </p>
    </div>
</body>
</html>
