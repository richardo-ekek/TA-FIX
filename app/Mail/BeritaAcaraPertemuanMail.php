<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BeritaAcaraPertemuanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $filePath;

    public function __construct($appointment, $filePath)
    {
        $this->appointment = $appointment;
        $this->filePath = $filePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Berita Acara Hasil Pertemuan Resmi - Kementerian Luar Negeri RI',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.berita_acara_appointment',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->filePath)
                    ->as('Berita-Acara-Pertemuan-' . $this->appointment->instansi . '.pdf')
                    ->withMime('application/pdf'),
        ];
    }
}