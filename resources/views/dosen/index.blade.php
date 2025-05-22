@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Dosen</h1>
        <a href="{{ route('dosen.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            <i class="fas fa-plus mr-1"></i> Tambah Dosen
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIDN</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Program Studi</th>
                        <th class="py-3 px-6 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($dosen as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-sm">{{ $d['nama'] }}</td>
                        <td class="py-4 px-6 text-sm">{{ $d['nidn'] }}</td>
                        <td class="py-4 px-6 text-sm">{{ $d['email'] }}</td>
                        <td class="py-4 px-6 text-sm">{{ $d['prodi'] }}</td>
                        <td class="py-4 px-6 text-sm text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('dosen.edit', $d['nidn']) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('dosen.destroy', $d['nidn']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center text-gray-500">Tidak ada data dosen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
