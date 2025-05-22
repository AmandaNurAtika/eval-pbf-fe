<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    protected $apiUrl = 'http://localhost:8080/dosen';

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $dosen = $response->json();

        return view('dosen.index', compact('dosen'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'nidn' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $response = Http::post($this->apiUrl, [
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ]);


        if ($response->successful()) {
            return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan dosen')->withInput();
    }

    public function edit($nidn)
    {
        $response = Http::get($this->apiUrl);
        $allDosen = $response->json();

        $dosen = collect($allDosen)->firstWhere('nidn', $nidn);

        if (!$dosen) {
            return redirect()->route('dosen.index')->with('error', 'Dosen tidak ditemukan');
        }

        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, $nidn)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'prodi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       $response = Http::put("{$this->apiUrl}/{$nidn}", [
            'nama' => $request->nama,
            'nidn' => $nidn,
            'email' => $request->email,
            'prodi' => $request->prodi,
        ]);

        if ($response->successful()) {
            return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui dosen')->withInput();
    }

    public function destroy($nidn)
    {
        $response = Http::delete("{$this->apiUrl}/{$nidn}");

        if ($response->successful()) {
            return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus');
        }

        return redirect()->route('dosen.index')->with('error', 'Gagal menghapus dosen');
    }
}
