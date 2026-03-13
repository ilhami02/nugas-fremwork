<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-base flex items-center gap-2 text-campus-blue">
                <svg class="w-5 h-5 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Data User
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-campus-blue transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar User
            </a>
        </div>
    </x-slot>

    @include('components.alerts')

    <div class="max-w-2xl">

        {{-- Form Edit User --}}
        <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="p-5 border-b border-campus-gray/30 flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-campus-blue/10 flex items-center justify-center text-campus-blue font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-campus-blue text-sm leading-tight">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="mt-1 block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm">
                    </div>

                    <div class="mb-6 p-4 bg-campus-blue/5 border border-campus-blue/20 rounded-lg">
                        <label for="is_admin" class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Hak Akses (Role)</label>
                        <p class="text-xs text-gray-500 mb-3">Mengubah user menjadi Admin memberikan hak penuh untuk mengelola arsip seminar dan user lain.</p>

                        <select name="is_admin" id="is_admin"
                                class="block w-full rounded-lg border-campus-gray/50 shadow-sm focus:border-campus-blue focus:ring-campus-blue text-sm font-medium text-gray-700"
                                {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                            <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>User Biasa</option>
                            <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Admin KMS</option>
                        </select>

                        @if(auth()->id() == $user->id)
                            <input type="hidden" name="is_admin" value="1">
                            <p class="text-xs text-campus-orange mt-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Anda tidak bisa mengubah hak akses akun Anda sendiri.
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center gap-1.5 border border-campus-gray/50 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone: Reset Password --}}
        <div class="bg-white border border-red-100 rounded-xl shadow-sm overflow-hidden">
            <div class="p-5 border-b border-red-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <h3 class="font-bold text-red-600 text-sm uppercase tracking-wider">Danger Zone</h3>
            </div>
            <div class="p-6">
                <p class="text-sm font-semibold text-gray-700 mb-1">Reset Password User</p>
                <p class="text-xs text-gray-500 mb-4">
                    Tindakan ini akan mereset password menjadi kata sandi default: <strong class="text-gray-700">password</strong>. Pastikan Anda memberitahu user yang bersangkutan setelahnya.
                </p>
                <form action="{{ route('admin.users.reset_password', $user->id) }}" method="POST"
                      onsubmit="return confirm('YAKIN INGIN MERESET PASSWORD USER INI? Password baru akan menjadi: password');">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-300 text-red-700 px-4 py-2 rounded-lg text-sm font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset Password ke Default
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>