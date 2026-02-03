# Dokumentasi Perbaikan: CaseResource & Controller

Dokumen ini menjelaskan masalah teknis yang ditemukan pada `CaseResource` dan `CaseController`, serta solusi yang diterapkan.

## 1. Masalah Utama

### A. Constructor `CaseResource` Salah Urutan

**Sebelumnya:**

```php
public function __construct($status, $message, $resource)
// Laravel error: Argument 1 passed to JsonResource must be the resource data
```

Laravel mewajibkan argumen pertama pada `JsonResource` adalah data resource-nya. Urutan custom `($status, $message, $resource)` menyebabkan konflik saat dipanggil oleh `collection()`.

### B. Pemanggilan Method Tidak Ada (`Undefined Method`)

**Sebelumnya:**

```php
CaseModel::findOrFail($id)->toResource(...)
```

Class Model tidak memiliki method `toResource()`. Ini menyebabkan _Fatal Error_.

## 2. Solusi & Perubahan Code

### A. Refactor `CaseResource.php`

Kami mengubah urutan parameter constructor agar sesuai standar Laravel (Resource ditaruh paling depan), dan menjadikan status/message opsional.

```php
public function __construct($resource, $status = true, $message = 'success')
{
    parent::__construct($resource); // Serahkan data ke parent (Laravel)
    $this->status = $status;
    $this->message = $message;
}
```

### B. Perbaikan `CaseController.php`

Kami mengubah cara memanggil resource dengan instansiasi manual menggunakan `new`.

```php
$case = CaseModel::findOrFail($id);
return new CaseResource($case);
// Output default: status=true, message='anjay berhasil rey' (sesuai default di class)
```

Atau jika ingin kustomisasi pesan:

```php
return new CaseResource($case, true, "Data ditemukan!");
```

## 3. Hasil Akhir (Response API)

Sekarang endpoint `GET /api/cases/{id}` akan menghasilkan JSON yang valid:

```json
{
    "data": {
        "status": true,
        "message": "anjay berhasil rey",
        "data": {
            "id": "...",
            "date": "...",
            "new_confirmed": 100,
            ...
        }
    }
}
```

**Catatan:** Struktur response sekarang memiliki wrapper `data` dua kali (satu dari Laravel Resource default, satu dari struktur custom kita). Ini normal dalam default behavior `JsonResource`.
