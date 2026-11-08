<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
            {{ __('Ubah Workspace') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 sm:p-8">
            <form method="POST" action="{{ route('workspaces.update', $workspace) }}">
                @csrf
                @method('PUT')

                <!-- Workspace Name -->
                <div class="mb-5">
                    <x-input-label for="name" :value="__('Nama Workspace')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $workspace->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        @if ($workspace->owner_id === Auth::id())
                            <button type="button" onclick="if(confirm('Hati-hati! Menghapus workspace akan menghapus seluruh proyek dan tugas di dalamnya. Lanjutkan?')) { document.getElementById('delete-workspace-form').submit(); }" class="text-xs font-semibold text-red-600 hover:text-red-800">
                                Hapus Workspace Ini
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('workspaces.show', $workspace) }}" class="px-4 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>

            @if ($workspace->owner_id === Auth::id())
                <form id="delete-workspace-form" method="POST" action="{{ route('workspaces.destroy', $workspace) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</x-app-layout>

