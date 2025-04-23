<x-filament-panels::page>

<div class="space-y-6">
    <div class="p-4 bg-white shadow rounded-lg dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <h2 class="text-lg font-bold mb-2">Update Aplikasi</h2>
        <p>Versi aplikasi terbaru atau perbaikan bug akan diperbaharui. Untuk melakukan update aplikasi silahkan konfirmasi terlebih dahulu kepada developer.</p>
        <p>Tekan tombol di bawah untuk melakukan update aplikasi.</p>
        <br>
        <x-filament::button wire:click="runBackup" class="mt-4 font-normal">
            Update Aplikasi
        </x-filament::button>

        @if (session()->has('success'))
            <div class="mt-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="p-6 bg-white shadow rounded-xl dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Riwayat Update</h2>

        <div class="overflow-x-auto">
            <ul>
                <li>
                    <strong># Rilis Update Aplikasi 1.5.0</strong> <small>(23 April 2025)</small>
                </li>
                <li>
                    - Fitur generate dan download QRCode Barcode untuk TTE pada surat keluar.
                </li>
                <li>
                    - Menu update aplikasi untuk mengupdate sistem aplikasi secara manual.
                </li>
            </ul>
        </div>
    </div>
</div>

</x-filament-panels::page>
