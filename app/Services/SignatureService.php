<?php

namespace App\Services;

use App\Models\TandaTangan;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class SignatureService
{
    /**
     * Get active signature for signing
     */
    public static function getActiveSignature()
    {
        return TandaTangan::active()->first();
    }

    /**
     * Get all active signatures
     */
    public static function getActiveSignatures()
    {
        return TandaTangan::active()->get();
    }

    /**
     * Sign a letter document
     */
    public static function signLetter(PengajuanSurat $pengajuan, TandaTangan $signature = null)
    {
        if (!$signature) {
            $signature = self::getActiveSignature();
        }

        if (!$signature) {
            throw new \Exception('Tidak ada tanda tangan aktif untuk menandatangani dokumen');
        }

        // Generate PDF with signature
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        // Add letter content
        $pdf->Cell(0, 10, 'SURAT KETERANGAN', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 11);
        $pdf->MultiCell(0, 5, $pengajuan->jenisSurat->nama_surat);
        $pdf->Ln(5);

        // Add signature
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(10);
        $pdf->Cell(0, 5, 'Mengetahui,', 0, 1);
        $pdf->Ln(5);

        // Add signature image
        if (strpos($signature->signature_image, 'data:image') === 0) {
            // Data URI format
            $imageData = base64_decode(explode(',', $signature->signature_image)[1]);
            $imagePath = storage_path('temp_signature.png');
            file_put_contents($imagePath, $imageData);
            $pdf->Image($imagePath, 20, $pdf->GetY(), 40, 20);
            unlink($imagePath);
        } else {
            // File path
            $pdf->Image($signature->signature_image, 20, $pdf->GetY(), 40, 20);
        }

        $pdf->Ln(25);
        $pdf->Cell(0, 5, $signature->nama_penanda_tangan, 0, 1);
        $pdf->Cell(0, 5, $signature->jabatan, 0, 1);

        if ($signature->nip) {
            $pdf->Cell(0, 5, 'NIP: ' . $signature->nip, 0, 1);
        }

        // Save PDF
        $filename = 'surat_' . $pengajuan->id . '_signed.pdf';
        $path = 'signed_letters/' . $filename;
        
        $pdfContent = $pdf->Output('', 'S');
        Storage::disk('public')->put($path, $pdfContent);

        return $path;
    }

    /**
     * Verify signature validity
     */
    public static function verifySignature(TandaTangan $signature)
    {
        return $signature->isValid();
    }

    /**
     * Get signature info for display
     */
    public static function getSignatureInfo(TandaTangan $signature)
    {
        return [
            'nama' => $signature->nama_penanda_tangan,
            'jabatan' => $signature->jabatan,
            'nip' => $signature->nip,
            'tipe' => $signature->signature_type,
            'aktif' => $signature->is_active,
            'valid' => $signature->isValid(),
            'berlaku_dari' => $signature->berlaku_dari?->format('d/m/Y'),
            'berlaku_sampai' => $signature->berlaku_sampai?->format('d/m/Y'),
        ];
    }

    /**
     * Add signature to existing PDF
     */
    public static function addSignatureToPDF($pdfPath, TandaTangan $signature)
    {
        // Read existing PDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);

        // Add signature
        $pdf->Ln(10);
        $pdf->Cell(0, 5, 'Mengetahui,', 0, 1);
        $pdf->Ln(5);

        // Add signature image
        if (strpos($signature->signature_image, 'data:image') === 0) {
            $imageData = base64_decode(explode(',', $signature->signature_image)[1]);
            $imagePath = storage_path('temp_signature.png');
            file_put_contents($imagePath, $imageData);
            $pdf->Image($imagePath, 20, $pdf->GetY(), 40, 20);
            unlink($imagePath);
        } else {
            $pdf->Image($signature->signature_image, 20, $pdf->GetY(), 40, 20);
        }

        $pdf->Ln(25);
        $pdf->Cell(0, 5, $signature->nama_penanda_tangan, 0, 1);
        $pdf->Cell(0, 5, $signature->jabatan, 0, 1);

        if ($signature->nip) {
            $pdf->Cell(0, 5, 'NIP: ' . $signature->nip, 0, 1);
        }

        return $pdf;
    }

    /**
     * Get signature audit trail
     */
    public static function getAuditTrail(PengajuanSurat $pengajuan)
    {
        return [
            'pengajuan_id' => $pengajuan->id,
            'ditandatangani_oleh' => $pengajuan->kades_id,
            'tanggal_penandatanganan' => $pengajuan->updated_at,
            'status' => $pengajuan->status,
        ];
    }
}
