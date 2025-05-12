<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Clusters\Settings;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\On;

class UpdatePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';
    protected static ?string $cluster = Settings::class;
    protected static ?string $navigationLabel = 'Update Aplikasi';
    protected ?string $heading = 'Update Aplikasi';
    protected static string $view = 'filament.pages.update-pages';

    public string $osName;
    public string $updateLog = "";

    /**
     * Deteksi OS saat halaman dibuka.
     */
    public function mount()
    {
        $this->osName = PHP_OS_FAMILY;
    }

    /**
     * Kirim data ke halaman Filament.
     */
    protected function viewData(): array
    {
        return [
            'osName' => $this->osName,
            'updateLog' => $this->updateLog,
        ];
    }

    /**
     * Ambil commit history dari Git.
     */
    public function getGitCommits(): string
    {
        $command = 'git log --pretty=format:"%h - %s (%ci)" --abbrev-commit -n 5';

        $process = proc_open($command, [
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w'], // STDERR
        ], $pipes);

        $gitCommits = "";

        if (is_resource($process)) {
            while (!feof($pipes[1])) {
                $gitCommits .= fgets($pipes[1]) . "\n";
            }

            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        }

        return $gitCommits;
    }

    /**
     * Jalankan update aplikasi dengan output live.
     */
    #[On('runUpdateApp')]
    public function runUpdateApp()
    {
        $this->updateLog = "Menjalankan pembaruan...\n"; // Kosongkan log sebelum update dimulai

        // Deteksi OS
        $isWindows = $this->osName === 'Windows';
        $git = $isWindows ? '"C:\\Program Files\\Git\\cmd\\git.exe"' : 'git';
        $composer = $isWindows ? '"C:\\ProgramData\\ComposerSetup\\bin\\composer.bat"' : 'composer';

        // Tentukan perintah update berdasarkan OS
        $command = $isWindows
            ? 'cd ' . base_path() . ' && ' . $git . ' stash && ' . $git . ' clean -df && ' . $git . ' pull origin main && ' . $composer . ' update'
            : 'cd ' . base_path() . ' && git stash && git clean -df && git pull origin main && composer update';

        // Jalankan perintah menggunakan proc_open() untuk menangkap output real-time
        $process = proc_open($command, [
            1 => ['pipe', 'w'], // STDOUT
            2 => ['pipe', 'w']  // STDERR
        ], $pipes);

        if (is_resource($process)) {
            while (!feof($pipes[1])) {
                $this->updateLog .= preg_replace('/<br>+/i', "\n", trim(fgets($pipes[1]))) . "\n"; // Menyimpan hasil output ke variabel
                $this->dispatch('updateLogUpdated'); // Memicu event Livewire agar UI diperbarui secara real-time
                usleep(500000); // Tunggu sebentar agar tampilan tidak terlalu cepat
            }

            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        }

        $this->updateLog .= "Riwayat Update:\n" . $this->getGitCommits() . "\n";

        // Jalankan perintah artisan secara langsung
        Artisan::call('migrate');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');

        // Tambahkan output dari Artisan ke dalam log
        $this->updateLog .= nl2br(Artisan::output());

        // Kirim notifikasi sukses
        // Notification::make()
        //     ->title("Update Aplikasi Berhasil")
        //     ->body("Proses update selesai.")
        //     ->success()
        //     ->send();
    }
}
