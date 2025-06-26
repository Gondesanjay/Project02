<?php

namespace App\Mail;

use App\Models\Ujian; // <-- Import model Ujian
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UjianReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ujian $ujian; // <-- Buat properti publik untuk menampung data ujian

    /**
     * Create a new message instance.
     */
    public function __construct(Ujian $ujian) // <-- Terima objek Ujian saat class dibuat
    {
        $this->ujian = $ujian; // <-- Simpan objek Ujian ke dalam properti
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Jadwal Ujian: ' . $this->ujian->nama_ujian, // <-- Atur subjek email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ujian.reminder', // <-- Tunjuk ke file view markdown kita
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
