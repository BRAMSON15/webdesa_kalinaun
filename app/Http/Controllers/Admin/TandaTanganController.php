<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TandaTangan;
use Illuminate\Http\Request;

class TandaTanganController extends Controller
{
    /**
     * Display a listing of signatures
     */
    public function index()
    {
        $tandaTangans = TandaTangan::latest()->get();
        return view('admin.tanda-tangan.index', compact('tandaTangans'));
    }

    /**
     * Show the form for creating a new signature
     */
    public function create()
    {
        return view('admin.tanda-tangan.create');
    }

    /**
     * Store a newly created signature in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penanda_tangan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20',
            'signature_image' => 'required|string', // Base64 encoded
            'signature_type' => 'required|in:digital,scanned',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
        ]);

        // Validate base64 image
        if (!$this->isValidBase64($request->signature_image)) {
            return back()->withErrors(['signature_image' => 'Format tanda tangan tidak valid']);
        }

        TandaTangan::create([
            'admin_id' => auth('admin')->id(),
            'nama_penanda_tangan' => $request->nama_penanda_tangan,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'signature_image' => $request->signature_image,
            'signature_type' => $request->signature_type,
            'berlaku_dari' => $request->berlaku_dari,
            'berlaku_sampai' => $request->berlaku_sampai,
            'is_active' => true,
        ]);

        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Tanda tangan berhasil ditambahkan');
    }

    /**
     * Display the specified signature
     */
    public function show($id)
    {
        $tandaTangan = TandaTangan::findOrFail($id);
        return view('admin.tanda-tangan.show', compact('tandaTangan'));
    }

    /**
     * Show the form for editing the specified signature
     */
    public function edit($id)
    {
        $tandaTangan = TandaTangan::findOrFail($id);
        return view('admin.tanda-tangan.edit', compact('tandaTangan'));
    }

    /**
     * Update the specified signature in storage
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penanda_tangan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20',
            'signature_image' => 'nullable|string', // Base64 encoded
            'signature_type' => 'required|in:digital,scanned',
            'berlaku_dari' => 'nullable|date',
            'berlaku_sampai' => 'nullable|date|after:berlaku_dari',
            'is_active' => 'nullable|boolean',
        ]);

        $tandaTangan = TandaTangan::findOrFail($id);

        $data = [
            'nama_penanda_tangan' => $request->nama_penanda_tangan,
            'jabatan' => $request->jabatan,
            'nip' => $request->nip,
            'signature_type' => $request->signature_type,
            'berlaku_dari' => $request->berlaku_dari,
            'berlaku_sampai' => $request->berlaku_sampai,
            'is_active' => $request->has('is_active'),
        ];

        // Update signature image if provided
        if ($request->has('signature_image') && !empty($request->signature_image)) {
            if (!$this->isValidBase64($request->signature_image)) {
                return back()->withErrors(['signature_image' => 'Format tanda tangan tidak valid']);
            }
            $data['signature_image'] = $request->signature_image;
        }

        $tandaTangan->update($data);

        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Tanda tangan berhasil diperbarui');
    }

    /**
     * Remove the specified signature from storage
     */
    public function destroy($id)
    {
        $tandaTangan = TandaTangan::findOrFail($id);
        $tandaTangan->delete();

        return redirect()->route('admin.tanda-tangan.index')->with('success', 'Tanda tangan berhasil dihapus');
    }

    /**
     * Toggle signature active status
     */
    public function toggleActive($id)
    {
        $tandaTangan = TandaTangan::findOrFail($id);
        $tandaTangan->update(['is_active' => !$tandaTangan->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status tanda tangan berhasil diubah',
            'is_active' => $tandaTangan->is_active,
        ]);
    }

    /**
     * Get active signatures for API
     */
    public function getActive()
    {
        $signatures = TandaTangan::active()->get();

        return response()->json([
            'success' => true,
            'data' => $signatures,
        ]);
    }

    /**
     * Validate base64 string
     */
    private function isValidBase64($string)
    {
        if (!is_string($string)) {
            return false;
        }

        // Check if it's a data URI
        if (strpos($string, 'data:image') === 0) {
            return true;
        }

        // Check if it's valid base64
        if (base64_encode(base64_decode($string, true)) === $string) {
            return true;
        }

        return false;
    }
}
