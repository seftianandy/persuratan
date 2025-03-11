<x-filament-panels::page>

<div class="space-y-6">
    <div class="p-4 bg-white shadow rounded-lg">
        <h2 class="text-lg font-bold mb-2">Backup Manual</h2>
        <p style="font-size: .97rem;">Selalu backup data anda secara berkala untuk meminimalisir kehilangan data karena berbagai macam ancaman seperti virus dan human error.</p>
        <p style="font-size: .97rem;">Tekan tombol di bawah untuk melakukan backup data secara manual.</p>
        <br>
        <x-filament::button wire:click="runBackup" class="mt-4">
            Jalankan Backup
        </x-filament::button>

        @if (session()->has('success'))
            <div class="mt-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="p-6 bg-white shadow rounded-xl">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Daftar Backup Data</h2>

        <div class="overflow-x-auto">
            <table class="w-full overflow-x-auto bg-white border border-gray-200 rounded-xl">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Backup File</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->getBackupFiles() as $index => $backup)
                        <tr class="text-gray-700">
                            <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('admin.settings.backup-download', ['file' => basename($backup)]) }}"
                                   class="text-blue-600 hover:text-blue-800 transition">
                                    {{ basename($backup) }}
                                </a>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <x-filament::button wire:click="deleteBackup('{{ basename($backup) }}')" color="danger" size="sm">
                                    Hapus
                                </x-filament::button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Belum ada backup.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-filament-panels::page>
