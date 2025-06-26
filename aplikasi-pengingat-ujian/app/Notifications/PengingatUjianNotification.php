<?php

namespace App\Notifications;

use App\Models\Ujian;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PengingatUjianNotification extends Notification
{
    use Queueable;

    public Ujian $ujian;

    public function __construct(Ujian $ujian)
    {
        $this->ujian = $ujian;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // --- PERBAIKAN DI SINI ---
        // Cek dulu apakah relasi mataPelajaran ada. Jika tidak, gunakan teks default.
        $namaMapel = $this->ujian->mataPelajaran ? $this->ujian->mataPelajaran->nama_mapel : '[Mata Pelajaran Tidak Ditemukan]';

        $url = route('filament.admin.resources.ujians.edit', $this->ujian);

        return (new MailMessage)
            ->subject('Pengingat Ujian: ' . $this->ujian->nama_ujian)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ini adalah pengingat bahwa ujian akan segera tiba.')
            ->line('**Nama Ujian:** ' . $this->ujian->nama_ujian)
            ->line('**Mata Pelajaran:** ' . $namaMapel) // Gunakan variabel yang sudah aman
            ->line('**Waktu Pelaksanaan:** ' . $this->ujian->tanggal_ujian->format('l, d F Y \p\u\k\u\l H:i'))
            ->action('Lihat Detail Ujian', $url)
            ->line('Selamat belajar dan semoga sukses!');
    }

    public function toArray(object $notifiable): array
    {
        // --- PERBAIKAN DI SINI JUGA ---
        $namaMapel = $this->ujian->mataPelajaran ? $this->ujian->mataPelajaran->nama_mapel : '[Mata Pelajaran Tidak Ditemukan]';

        return [
            'nama_ujian' => $this->ujian->nama_ujian,
            'mata_pelajaran' => $namaMapel, // Gunakan variabel yang sudah aman
            'tanggal_ujian' => $this->ujian->tanggal_ujian->format('d F Y'),
        ];
    }
}
