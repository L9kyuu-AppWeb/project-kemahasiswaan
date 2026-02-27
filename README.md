# Sistem Kemahasiswaan

Sistem Kemahasiswaan adalah platform terintegrasi berbasis web untuk pengelolaan kegiatan kemahasiswaan, termasuk beasiswa, magang, dan pengumuman akademik. Dibangun menggunakan Laravel framework.

## 🚀 Fitur Utama

### 📋 Manajemen Beasiswa
- **Jenis Beasiswa** - Kelola berbagai tipe beasiswa (aktif/tidak aktif)
- **Data Penerima** - Catat dan kelola mahasiswa penerima beasiswa
- **Laporan Akademik** - Monitor IPK, SKS, dan KHS mahasiswa penerima beasiswa
- **Laporan Terkelola** - Laporan dikelompokkan per mahasiswa untuk memudahkan monitoring

### 💼 Manajemen Magang
- **Penempatan Magang** - Kelola penempatan mahasiswa di perusahaan
- **Laporan Kegiatan** - Monitor laporan harian/mingguan mahasiswa magang
- **Log Kegiatan** - Detail aktivitas dengan bukti kegiatan (PDF)
- **Verifikasi Laporan** - Approval dan review laporan magang

### 👨‍🎓 Manajemen Mahasiswa
- **Data Mahasiswa** - CRUD data mahasiswa lengkap dengan program studi
- **Program Studi** - Kelola data program studi/jurusan

### 📢 Pengumuman
- **Pengumuman Beasiswa** - Informasi pendaftaran dan hasil seleksi beasiswa
- **Pengumuman Umum** - Informasi kegiatan kemahasiswaan

### 📊 Sistem Laporan Terintegrasi
- **Grouping by Mahasiswa** - Laporan dikelompokkan per mahasiswa
- **Status Tracking** - Draft, Submitted, Approved, Rejected
- **Export PDF** - Download laporan individual atau multiple
- **Verifikasi Admin** - Proses approval dengan catatan

### 🔐 Multi-User Authentication
- **Admin** - Administrator sistem
- **Mahasiswa** - User mahasiswa dengan NIM

## 🛠️ Teknologi

- **Backend**: Laravel 10.x
- **Database**: MySQL
- **Frontend**: Blade Templates + TailwindCSS
- **Icons**: Font Awesome 6
- **PDF Generation**: DomPDF
- **Authentication**: Laravel Guard (Admin & Mahasiswa)

## 📦 Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (opsional untuk asset compilation)

### Langkah Instalasi

1. **Clone repository**
```bash
git clone <repository-url>
cd project_kemahasiswaan
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database** - Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_kemahasiswaan
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan migrasi dan seeder**
```bash
php artisan migrate --seed
```

6. **Storage link** (untuk upload file)
```bash
php artisan storage:link
```

7. **Jalankan aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 📁 Struktur Database

### Tabel Utama
- `admins` - Data administrator
- `mahasiswas` - Data mahasiswa
- `program_studis` - Data program studi
- `beasiswa_tipes` - Jenis/tipe beasiswa
- `mahasiswa_beasiswas` - Mahasiswa penerima beasiswa
- `laporan_beasiswas` - Laporan beasiswa mahasiswa
- `laporan_akademiks` - Data akademik (IPK, SKS, KHS)
- `laporan_referals` - Laporan referal
- `laporan_pendanaans` - Laporan pendanaan/kompetisi
- `laporan_kompetisis` - Laporan kompetisi
- `laporan_publikasis` - Laporan publikasi
- `mahasiswa_magangs` - Penempatan magang
- `laporan_magangs` - Laporan magang
- `log_kegiatans` - Log kegiatan magang
- `bukti_kegiatans` - Bukti kegiatan (file)
- `pengumumans` - Pengumuman
- `tahun_ajars` - Tahun akademik

## 🔑 Default Login

### Admin
```
Email: admin@example.com
Password: password
```

### Mahasiswa
```
NIM: 2024001
Password: password
```

## 📸 Fitur Unggulan

### 1. Laporan Beasiswa (Grouped)
- Tampilan daftar laporan dikelompokkan per mahasiswa
- Summary status: Draft, Submitted, Approved, Rejected
- Detail laporan per mahasiswa dengan riwayat lengkap
- Download PDF individual atau multiple

### 2. Laporan Magang (Grouped)
- Monitoring laporan magang per mahasiswa
- Total laporan dan status summary
- Log kegiatan dengan bukti PDF
- Verifikasi dan approval laporan

### 3. Manajemen Beasiswa
- Master data jenis beasiswa
- Transaksi penerima beasiswa per mahasiswa
- Upload file SK beasiswa
- Status aktif/tidak aktif

## 🗂️ Struktur Folder Penting

```
app/
├── Http/
│   └── Controllers/
│       ├── Admin/
│       ├── BeasiswaController.php
│       ├── LaporanController.php
│       ├── LaporanMagangController.php
│       ├── MahasiswaController.php
│       └── ...
├── Models/
│   ├── LaporanBeasiswa.php
│   ├── LaporanMagang.php
│   ├── MahasiswaBeasiswa.php
│   └── ...
resources/
├── views/
│   ├── admin/
│   │   ├── laporan/
│   │   │   ├── index.blade.php (grouped)
│   │   │   ├── mahasiswa-detail.blade.php
│   │   │   └── show.blade.php
│   │   ├── laporan-magang/
│   │   │   ├── index.blade.php (grouped)
│   │   │   ├── mahasiswa-detail.blade.php
│   │   │   └── show.blade.php
│   │   ├── beasiswa/
│   │   └── ...
│   ├── mahasiswa/
│   └── home.blade.php
```

## 📝 Route Utama

### Admin Routes (`/admin`)
```php
// Laporan Beasiswa
GET  /admin/laporan              - Index (grouped by mahasiswa)
GET  /admin/laporan/mahasiswa/{id} - Detail per mahasiswa
GET  /admin/laporan/{id}         - Show detail laporan
POST /admin/laporan/{id}/approve - Approve laporan
POST /admin/laporan/{id}/reject  - Reject laporan

// Laporan Magang
GET  /admin/laporan-magang       - Index (grouped by mahasiswa)
GET  /admin/laporan-magang/mahasiswa/{id} - Detail per mahasiswa
GET  /admin/laporan-magang/{id}  - Show detail laporan
POST /admin/laporan-magang/{id}/approve - Approve laporan
POST /admin/laporan-magang/{id}/reject  - Reject laporan

// Beasiswa
GET  /admin/beasiswa/tipe        - Jenis beasiswa
GET  /admin/beasiswa/data        - Data penerima beasiswa
```

### Mahasiswa Routes (`/mahasiswa`)
```php
// Laporan Beasiswa
GET  /mahasiswa/laporan          - Daftar laporan
POST /mahasiswa/laporan          - Store laporan
POST /mahasiswa/laporan/{id}/submit - Submit laporan

// Laporan Magang
GET  /mahasiswa/laporan-magang   - Daftar laporan magang
POST /mahasiswa/laporan-magang   - Store laporan magang
```

## 🔧 Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database
php artisan migrate
php artisan migrate:rollback
php artisan db:seed
```

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Developer

Sistem Kemahasiswaan - Platform terintegrasi untuk pengelolaan kegiatan kemahasiswaan.

---

**© 2026 Sistem Kemahasiswaan. All rights reserved.**
