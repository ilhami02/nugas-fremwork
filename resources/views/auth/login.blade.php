<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold mb-1" style="color: #0f2c5e;">Selamat Datang!</h2>
    <p class="text-sm text-gray-500 mb-6">Masuk ke Knowledge Management System PNC</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Alamat Email</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                <x-text-input id="email" class="block mt-0 w-full pl-9 campus-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="padding-left: 2.25rem;" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold mb-1.5" style="color: #0f2c5e;">Kata Sandi</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <x-text-input id="password" class="block mt-0 w-full pl-9 campus-input" type="password" name="password" required autocomplete="current-password" style="padding-left: 2.25rem;" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 focus:ring-0" style="accent-color: #0f2c5e;" name="remember">
                <span class="text-xs text-gray-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-xs font-medium hover:underline" style="color: #0f2c5e;" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2" style="font-size: 0.9rem;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            Masuk
        </button>

        @if (Route::has('register'))
            <p class="text-center text-xs text-gray-500 mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: #0f2c5e;">Daftar Sekarang</a>
            </p>
        @endif
    </form>
</x-guest-layout>
