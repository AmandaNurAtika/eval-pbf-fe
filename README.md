# 🚀 SI-KRS Frontend - Laravel + Backend CodeIgniter
Ini adalah proyek antarmuka pengguna (frontend) berbasis Laravel 10 dan Tailwind CSS yang dirancang untuk terhubung dengan backend REST API (dibangun dengan CodeIgniter 4). Aplikasi ini digunakan untuk mengelola data Mahasiswa, Program Studi (Prodi), dan Kelas.

- [Backend](https://github.com/abdau88/eval_pbf_frontend.git)
- Database/Table
```
CREATE TABLE `dosen` (
`id ` INT AUTO_INCRERMENT,
  `nama` varchar(100) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  PRIMARY KEY (`nidn`)
);

INSERT INTO `dosens` (`nama`, `nidn`, `email`, `prodi`) VALUES
('Dr. Bambang', '12345678', 'bambang@kampus.ac.id', 'Teknik Informatika'),
('Dr. Siti', '87654321', 'siti@kampus.ac.id', 'Sistem Informasi');

CREATE TABLE `mahasiswa` (
`id ` INT AUTO_INCRERMENT,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  PRIMARY KEY (`nim`)
);

INSERT INTO `mahasiswas` (`nama`, `nim`, `email`, `prodi`) VALUES
('Andi Saputra', '210001', 'andi@kampus.ac.id', 'Teknik Informatika'),
('Rina Melati', '210002', 'rina@kampus.ac.id', 'Sistem Informasi');
```

- Endpoint
```
Dosen
- GET → http://localhost:8080/dosen
- POST → http://localhost:8080/dosen
- PUT → http://localhost:8080/dosen/{nidn}
- DELETE → http://localhost:8080/dosen/{nidn}
Mahasiswa
- GET → http://localhost:8080/mahasiswa
- POST → http://localhost:8080/mahasiswa
- PUT → http://localhost:8080/mahasiswa/{nim}
- DELETE → http://localhost:8080/mahasiswa/{nim}
```
# ⚙ Teknologi
- Laravel 10
- Tailwind CSS
- Laravel HTTP Client (untuk konsumsi API)
- Vite (build asset frontend)
- REST API (CodeIgniter 4)

# 🧩 Struktur Sistem
Frontend Laravel ini tidak menyimpan data ke database lokal. Semua proses Create, Read, Update, dan Delete dilakukan melalui REST API backend CodeIgniter.

# 🚀 SETUP BACKEND
1. Clone Repository BE
```
git clone https://github.com/abdau88/eval_pbf_frontend.git
```
```
cd nama-file
```
2. Install Dependency CodeIgniter
``
composer install
``
4. Copy File Environment
```
cp .env.example .env
```
6. Menjalankan CodeIgniter
```
php spark serve
```
8. Cek EndPoint menggunakan Postman
- Kelas :
```
- GET → http://localhost:8080/kelas / http://localhost:8080/kelas/{id}
- POST → http://localhost:8080/kelas
- PUT → http://localhost:8080/kelas/{id}
- DELETE → http://localhost:8080/kelas/{id}
```
- Prodi :
```
- GET → http://localhost:8080/prodi / http://localhost:8080/prodi/{id}
- POST → http://localhost:8080/prodi
- PUT → http://localhost:8080/prodi/{id}
- DELETE → http://localhost:8080/prodi/{id}
```

# 🚀 SETUP FRONTEND
1. Install Laravel
Install di CMD atau Terminal
```
composer create-priject laravel/laravel nama-project
```

2. Install Dependency Laravel
```
composer install
```
3. Copy File Environment
```
cp .env.example .env
```
4. Set .env untuk Non-Database App
```
APP_NAME=Laravel
APP_URL=http://localhost:8000
SESSION_DRIVER=file
```

5. Cara Menjalankan Laravel server
```
php artisan serve
```

## 🧩  Routes
```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Dosen Routes
Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
Route::post('/dosen', [DosenController::class, 'store'])->name('dosen.store');
Route::get('/dosen/{nidn}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
Route::put('/dosen/{nidn}', [DosenController::class, 'update'])->name('dosen.update');
Route::delete('/dosen/{nidn}', [DosenController::class, 'destroy'])->name('dosen.destroy');

// Mahasiswa Routes
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{nim}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{nim}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/{nim}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

```

## 🧩  Controllers

1. Controller.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

```
2. DashboardController.php
```
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

```

3. DosenController.php
```
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

```

## 🧩  Models
1. Mahasiswa.php
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'nama',
        'nim',
        'email',
        'prodi',
    ];
}
```

2. Dosen.php
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'nama',
        'nidn',
        'email',
        'prodi',
    ];
}
```
