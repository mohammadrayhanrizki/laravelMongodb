# Dokumentasi Konsolidasi Controller (CaseController)

Dokumen ini menjelaskan perubahan arsitektur pada `CaseController` di mana logika untuk Web (View) dan API (JSON) digabungkan ke dalam satu file controller.

## 1. Latar Belakang

Sebelumnya, terdapat dua controller terpisah:

1.  `App\Http\Controllers\CaseController` (Untuk Web/View)
2.  `App\Http\Controllers\Api\CaseController` (Untuk API/JSON)

Untuk menyederhanakan struktur dan memusatkan logika bisnis terkait "Cases", kedua fungsi ini digabungkan ke dalam satu controller yaitu `App\Http\Controllers\Api\CaseController`.

## 2. Arsitektur Baru

**Controller Tunggal:** `App\Http\Controllers\Api\CaseController`

Controller ini sekarang memiliki dua tanggung jawab utama yang dipisahkan oleh _method_:

| Route Type | URL          | Method di Controller | Output                                              |
| :--------- | :----------- | :------------------- | :-------------------------------------------------- |
| **API**    | `/api/cases` | `index()`            | **JSON** (Data mentah untuk aplikasi/frontend lain) |
| **Web**    | `/cases`     | `dashboard()`        | **View (HTML)** (Tampilan dashboard untuk browser)  |

## 3. Implementasi Teknis

### A. Controller Code (`Api\CaseController.php`)

Di dalam class `CaseController`, kita menambahkan method `dashboard` tanpa mengganggu method API yang sudah ada.

```php
namespace App\Http\Controllers\Api;

class CaseController extends Controller
{
    // --- KHUSUS WEB (Browser) ---
    public function dashboard()
    {
        // Logika mengambil data untuk chart & tabel
        $chartData = CaseModel::...;
        $cases = CaseModel::...;

        // Mengembalikan View (Blade)
        return view('cases.index', compact('chartData', 'cases', ...));
    }

    // --- KHUSUS API (Mobile/External) ---
    public function index()
    {
        // Mengembalikan JSON
        return CaseResource::collection(CaseModel::all());
    }
}
```

### B. Konfigurasi Route

**1. Route Web (`routes/web.php`)**
Mengarah ke method `dashboard`.

```php
use App\Http\Controllers\Api\CaseController;

Route::get('/cases', [CaseController::class, 'dashboard']);
```

**2. Route API (`routes/api.php`)**
Tetap menggunakan resource standard (mengarah ke `index`, `store`, `show`, dll).

```php
use App\Http\Controllers\Api\CaseController;

Route::apiResource('cases', CaseController::class);
```

## 4. Keuntungan

1.  **Sentralisasi**: Semua logika yang berhubungan dengan entitas `Case` ada di satu tempat.
2.  **Efisiensi**: Tidak perlu membuat file controller baru hanya untuk menampilkan satu halaman view.
3.  **Fleksibilitas**: Controller PHP (Laravel) bersifat agnostik; ia bisa mengembalikan View ataupun JSON tergantung method yang dipanggil.
