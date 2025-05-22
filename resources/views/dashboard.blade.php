@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Dosen</p>
                    <p class="text-2xl font-bold text-gray-700">{{ $dosenCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-700">{{ $mahasiswaCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Program Studi</p>
                    <p class="text-2xl font-bold text-gray-700">{{ count($dosenByProdi) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                    <i class="fas fa-chart-pie text-2xl"></i>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Dosen -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Dosen Terbaru</h2>
                <a href="{{ route('dosen.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIDN</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prodi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($dosen, 0, 5) as $d)
                            <tr>
                                <td class="py-2 px-4 border-b text-sm">{{ $d['nama'] }}</td>
                                <td class="py-2 px-4 border-b text-sm">{{ $d['nidn'] }}</td>
                                <td class="py-2 px-4 border-b text-sm">{{ $d['prodi'] }}</td>
                            </tr>
                            @endforeach
                            
                            @if(count($dosen) == 0)
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-gray-500">Tidak ada data dosen</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Mahasiswa -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Mahasiswa Terbaru</h2>
                <a href="{{ route('mahasiswa.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIM</th>
                                <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prodi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($mahasiswa, 0, 5) as $m)
                            <tr>
                                <td class="py-2 px-4 border-b text-sm">{{ $m['nama'] }}</td>
                                <td class="py-2 px-4 border-b text-sm">{{ $m['nim'] }}</td>
                                <td class="py-2 px-4 border-b text-sm">{{ $m['prodi'] }}</td>
                            </tr>
                            @endforeach
                            
                            @if(count($mahasiswa) == 0)
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-center text-gray-500">Tidak ada data mahasiswa</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
