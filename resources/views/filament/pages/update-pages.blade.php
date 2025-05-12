<x-filament-panels::page>

<div class="space-y-6">
    <div class="p-4 bg-white shadow rounded-lg dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <h2 class="text-lg font-bold mb-2">Update Aplikasi</h2>
        <div class="text-gray-700 text-sm mb-4">
            <strong>Sistem Operasi:</strong> {{ $osName }}
        </div>
        <p>Versi aplikasi terbaru atau perbaikan bug akan diperbaharui. Untuk melakukan update aplikasi silahkan konfirmasi terlebih dahulu kepada developer.</p>
        <p>Tekan tombol di bawah untuk melakukan update aplikasi, dan setelah berhasil update silahkan untuk merefresh halaman.</p>
        <br>
        <x-filament::button wire:click="runUpdateApp" class="mt-4 font-normal">
            Update Aplikasi
        </x-filament::button>
        <div class="mt-6 p-4 text-white text-sm font-mono rounded-lg overflow-auto max-h-64" style="background-color: black" wire:poll.500ms="$refresh">
            <pre>{{ $updateLog }}</pre>
        </div>

        @if (session()->has('success'))
            <div class="mt-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="p-6 bg-white shadow rounded-xl dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Riwayat Update</h2>
        <div class="overflow-x-auto">
            <ul class="list-none space-y-4">
                <li>
                    <div class="font-bold text-gray-700"># Rilis Update Aplikasi 1.5.1</div>
                    <small class="text-gray-500">(12 Mei 2025)</small>
                    <ul class="list-disc list-inside pl-5 mt-1 space-y-2 text-gray-800">
                        <li>
                            Fitur contoh surat keluar untuk pengajuan surat keluar. <br>
                            User dapat mengunggah dan mengunduh contoh surat keluar sesuai dengan jenis surat yang dibutuhkan.
                        </li>
                    </ul>
                </li>

                <li>
                    <div class="font-bold text-gray-700"># Rilis Update Aplikasi 1.5.0</div>
                    <small class="text-gray-500">(23 April 2025)</small>
                    <ul class="list-disc list-inside pl-5 mt-1 space-y-2 text-gray-800">
                        <li>Fitur generate dan download QRCode Barcode untuk TTE pada surat keluar.</li>
                        <li>Menu update aplikasi untuk melakukan update sistem aplikasi secara manual.</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

</x-filament-panels::page>
