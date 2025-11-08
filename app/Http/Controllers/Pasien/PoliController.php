<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function get()
    {
        $user = Auth::user();
        $polis = Poli::all();
        $jadwal = JadwalPeriksa::with('dokter', 'dokter.poli')->get();

        return view('pasien.daftar', [
            'user' => $user,
            'polis' => $polis,
            'jadwals' => $jadwal,
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'nullable|string',
        ]);

        // Ambil user pasien yang sedang login
        $user = Auth::user();

        // Hitung nomor antrian berdasarkan jadwal yang dipilih
        $jumlahSudahDaftar = DaftarPoli::where('id_jadwal', $request->id_jadwal)->count();

        // Simpan data ke tabel daftar_poli
        DaftarPoli::create([
            'id_pasien' => $user->id, // ✅ Ambil dari user login, bukan dari form
            'id_jadwal' => $request->id_jadwal, // ✅ variabel benar
            'keluhan' => $request->keluhan,
            'no_antrian' => $jumlahSudahDaftar + 1,
        ]);

        return redirect()->back()
            ->with('message', 'Berhasil mendaftar ke Poli!')
            ->with('type', 'success');
    }
}
