<?php

namespace App\Notifications;

use App\Models\Ujian;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UjianBaruDibuatNotification extends Notification
{
    use Queueable;

    protected Ujian $ujian;
    protected User $mahasiswa;

    /**
     * Buat instance notifikasi baru.
     */
    public function __construct(Ujian $ujian, User $mahasiswa)
    {
        $this->ujian = $ujian;
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Tentukan channel pengiriman notifikasi.
     * Kita hanya ingin menyimpannya ke database untuk saat ini.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Ubah notifikasi menjadi format array untuk disimpan di database.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ujian_id' => $this->ujian->id,
            'nama_ujian' => $this->ujian->nama_ujian,
            'nama_mahasiswa' => $this->mahasiswa->name,
            'pesan' => "Mahasiswa {$this->mahasiswa->name} baru saja menambahkan jadwal ujian '{$this->ujian->nama_ujian}'.",
            // URL ini akan mengarahkan admin ke halaman edit Ujian di panel admin
            'url' => \App\Filament\Resources\UjianResource::getUrl('edit', ['record' => $this->ujian]),
        ];
    }
}
