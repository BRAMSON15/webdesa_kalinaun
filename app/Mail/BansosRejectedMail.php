<?php

namespace App\Mail;

use App\Models\PenerimaBansos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BansosRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $penerima;

    public function __construct(PenerimaBansos $penerima)
    {
        $this->penerima = $penerima;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Bansos Anda Ditolak',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bansos-rejected',
            with: [
                'penerima' => $this->penerima,
                'bansos' => $this->penerima->bansos,
                'user' => $this->penerima->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
