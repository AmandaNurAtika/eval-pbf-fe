<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenResponse = Http::get('http://localhost:8080/dosen');
        $mahasiswaResponse = Http::get('http://localhost:8080/mahasiswa');
        
        $dosen = $dosenResponse->json();
        $mahasiswa = $mahasiswaResponse->json();
        
        $dosenCount = count($dosen);
        $mahasiswaCount = count($mahasiswa);
        
        // Group by prodi for statistics
        $dosenByProdi = collect($dosen)->groupBy('prodi')->map->count();
        $mahasiswaByProdi = collect($mahasiswa)->groupBy('prodi')->map->count();
        
        return view('dashboard', compact('dosenCount', 'mahasiswaCount', 'dosenByProdi', 'mahasiswaByProdi', 'dosen', 'mahasiswa'));
    }
}
