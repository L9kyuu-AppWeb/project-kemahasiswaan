🏗 1️⃣ Tabel Fakultas
CREATE TABLE fakultas (
    id_fakultas INT AUTO_INCREMENT PRIMARY KEY,
    nama_fakultas VARCHAR(100) NOT NULL
);
🏗 2️⃣ Tabel Program Studi
CREATE TABLE program_studi (
    id_prodi INT AUTO_INCREMENT PRIMARY KEY,
    nama_prodi VARCHAR(100) NOT NULL,
    jenjang VARCHAR(10) NOT NULL,
    id_fakultas INT NOT NULL,
    FOREIGN KEY (id_fakultas) REFERENCES fakultas(id_fakultas)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

Relasi:

1 Fakultas → banyak Program Studi

🏗 3️⃣ Tabel Mahasiswa (Data Umum)
CREATE TABLE mahasiswa (
    nim VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    tanggal_lahir DATE,
    alamat TEXT,
    angkatan YEAR,
    id_prodi INT NOT NULL,
    status_mahasiswa ENUM('Reguler','Beasiswa') DEFAULT 'Reguler',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_prodi) REFERENCES program_studi(id_prodi)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
🏗 4️⃣ Tabel Mahasiswa Beasiswa (Data Tambahan)

Mahasiswa yang menerima beasiswa akan memiliki data tambahan di tabel ini.

CREATE TABLE mahasiswa_beasiswa (
    id_beasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    jenis_beasiswa VARCHAR(100) NOT NULL,
    nomor_sk VARCHAR(100),
    tanggal_sk DATE,
    nominal DECIMAL(15,2),
    periode_mulai DATE,
    periode_selesai DATE,
    status_aktif BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
🔁 Relasi Akhir

fakultas (1) → (∞) program_studi

program_studi (1) → (∞) mahasiswa

mahasiswa (1) → (0..∞) mahasiswa_beasiswa