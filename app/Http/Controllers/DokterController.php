<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dimana role adalah dokter
        $dokters = User::where('role', 'dokter')->with('poli')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1. membuat validasi
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp',
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|string|exists:poli,id', // intinya id nya ada di poli
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        // dd($data);

        User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'id_poli' => $request->id_poli,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
        ]);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil di tambahkan')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    /**
     * Update the specified resource in storage.
     * $dokter adalah route model binding jadi yang harus nya kita buat
     * $dokter = User::findOrFail($id); kita bisa membuat menjadi parameter, 
     * namun jika menggunakan cara tersebut kita route nya tidak bisa admin/dokter{id}/edit namun 
     * seperi admin/dokter/{dokter}/edit
     */

    public function update(Request $request, User $dokter)
    {
        $request->validate([
            

        ]);

        $updateData = [
           

        ];

        //update password bila password disii
        if ($request->filled('password')) {
            $dokter->password = Hash::make($request->password);
        }

        //disimpan
        $dokter->update($updateData);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil di ubah')
            ->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil dihapus')
            ->with('type', 'success');
    }
}