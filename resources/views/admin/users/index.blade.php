<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-base flex items-center gap-2 text-campus-blue">
                <svg class="w-5 h-5 text-campus-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Manajemen User
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-campus-blue transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Panel Admin
            </a>
        </div>
    </x-slot>

    @include('components.alerts')

    {{-- Stat Card --}}
    <div class="mb-6">
        <div class="bg-white border border-campus-gray/40 border-l-4 border-l-campus-blue rounded-xl shadow-sm p-5 flex items-center gap-4 max-w-xs">
            <div class="p-3 rounded-xl bg-campus-blue/10">
                <svg class="w-6 h-6 text-campus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total User</p>
                <p class="text-3xl font-bold text-campus-blue">{{ $users->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-campus-gray/40 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-campus-gray/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h3 class="flex items-center gap-2 text-lg font-bold text-campus-blue">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Daftar Akun Terdaftar
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-campus-gray/30">
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Nama Lengkap</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Email</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Role</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400">Bergabung</th>
                        <th class="py-3 px-5 text-xs font-semibold uppercase tracking-wider text-gray-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-campus-gray/20 hover:bg-campus-blue/5 transition">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-campus-blue/10 flex items-center justify-center text-campus-blue font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                                        @if(auth()->id() == $user->id)
                                            <span class="ml-1.5 text-[0.65rem] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold">Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-5 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="py-4 px-5">
                                @if($user->is_admin)
                                    <span class="inline-block bg-campus-orange/10 text-campus-orange text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">Admin KMS</span>
                                @else
                                    <span class="inline-block bg-campus-blue/10 text-campus-blue text-[0.7rem] font-bold px-2.5 py-1 rounded-full tracking-wide uppercase">User Biasa</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-sm text-gray-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                       title="Edit User"
                                       class="p-1.5 rounded-lg hover:bg-campus-orange/10 transition text-campus-orange">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus User"
                                                class="p-1.5 rounded-lg hover:bg-red-50 transition text-red-400 {{ auth()->id() == $user->id ? 'opacity-30 cursor-not-allowed' : '' }}"
                                                {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>