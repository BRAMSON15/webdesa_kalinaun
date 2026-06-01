<?php

namespace App\Mail;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LetterCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    public function __construct(PengajuanSurat $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Anda Sudah Selesai Diproses',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.letter-completed',
            with: [
                'pengajuan' => $this->pengajuan,
                'jenisSurat' => $this->pengajuan->jenisSurat,
                'user' => $this->pengajuan->user,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
