<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'obat_json'      => 'required',
            'catatan'        => 'nullable|string',
            'biaya_periksa'  => 'required|integer|min:0',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // cegah json kosong / invalid
        if (!is_array($obatIds) || count($obatIds) === 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors('Obat belum dipilih.');
        }

        DB::beginTransaction();

        try {
            // 1) cek stok dulu (lock)
            $obatHabis = [];

            foreach ($obatIds as $idObat) {
                $obat = Obat::lockForUpdate()->find($idObat);

                if (!$obat) {
                    $obatHabis[] = 'Obat tidak ditemukan';
                    continue;
                }

                if ($obat->stok <= 0) {
                    $obatHabis[] = $obat->nama_obat;
                }
            }

            if (count($obatHabis) > 0) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors('Stok obat habis: ' . implode(', ', $obatHabis));
            }

            // 2) simpan periksa
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa'    => now(),
                'catatan'        => $request->catatan,
                'biaya_periksa'  => $request->biaya_periksa + 150000,
            ]);

            // 3) simpan detail + kurangi stok otomatis
            foreach ($obatIds as $idObat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat'    => $idObat,
                    'jumlah'     => 1, // default 1 (sesuai struktur sekarang)
                ]);

                Obat::where('id', $idObat)->decrement('stok', 1);
            }

            DB::commit();

            return redirect()
                ->route('periksa-pasien.index')
                ->with('success', 'Data periksa berhasil disimpan. Stok obat otomatis berkurang.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat menyimpan data.');
        }
    }
}
