<?php

namespace App\Notifications;

use App\Models\Ujian;
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

    /**
     * Menentukan channel pengiriman notifikasi (database DAN email).
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Memformat notifikasi untuk dikirim sebagai email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $namaMapel = $this->ujian->mataPelajaran->nama_mapel;
        $url = route('filament.admin.resources.ujians.edit', $this->ujian);

        return (new MailMessage)
            ->subject('Pengingat Ujian: ' . $this->ujian->nama_ujian)
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Ini adalah pengingat bahwa ujian akan segera tiba.')
            ->line('**Nama Ujian:** ' . $this->ujian->nama_ujian)
            ->line('**Mata Pelajaran:** ' . $namaMapel)
            ->line('**Waktu Pelaksanaan:** ' . $this->ujian->tanggal_ujian->format('l, d F Y \p\u\k\u\l H:i'))
            ->action('Lihat Detail Ujian', $url)
            ->line('Selamat belajar dan semoga sukses!');
    }

    /**
     * Memformat notifikasi untuk disimpan ke database (untuk ikon lonceng).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'nama_ujian' => $this->ujian->nama_ujian,
            'mata_pelajaran' => $this->ujian->mataPelajaran->nama_mapel,
            'tanggal_ujian' => $this->ujian->tanggal_ujian->format('d F Y'),
        ];
    }
}
