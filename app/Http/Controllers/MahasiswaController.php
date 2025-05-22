<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    protected $apiUrl = 'http://localhost:8080/mahasiswa';

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $mahasiswa = $response->json();
        
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $response = Http::post($this->apiUrl, [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ]);

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan mahasiswa')->withInput();
    }

    public function edit($nim)
    {
        $response = Http::get($this->apiUrl);
        $allMahasiswa = $response->json();
        
        $mahasiswa = collect($allMahasiswa)->firstWhere('nim', $nim);
        
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak ditemukan');
        }
        
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $nim)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::put("{$this->apiUrl}/{$nim}", [
            'nama' => $request->nama,
            'nim' => $nim,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ]);

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui mahasiswa')->withInput();
    }

    public function destroy($nim)
    {
        $response = Http::delete("{$this->apiUrl}/{$nim}");

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
        }

        return redirect()->route('mahasiswa.index')->with('error', 'Gagal menghapus mahasiswa');
    }
}
