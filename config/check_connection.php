<?php
// Konfigurasi Database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_sdit_lukmanalhakimsleman';

echo "<h2>Cek Koneksi Database</h2>";

// Cek koneksi ke server MySQL
echo "<h3>Koneksi ke Server MySQL:</h3>";
$conn_server = @mysqli_connect($host, $username, $password);
if ($conn_server) {
    echo "<p style='color:green'>✓ Berhasil terhubung ke server MySQL.</p>";
} else {
    echo "<p style='color:red'>✗ Gagal terhubung ke server MySQL: " . mysqli_connect_error() . "</p>";
    echo "<p>Solusi: Periksa konfigurasi host, username, dan password di file config/database.php.</p>";
    exit;
}

// Cek apakah database ada
echo "<h3>Cek Database:</h3>";
$result = mysqli_query($conn_server, "SHOW DATABASES LIKE '$database'");
if (mysqli_num_rows($result) > 0) {
    echo "<p style='color:green'>✓ Database '$database' ditemukan.</p>";
} else {
    echo "<p style='color:red'>✗ Database '$database' tidak ditemukan.</p>";
    echo "<p>Solusi: Jalankan <a href='../admin/migrate.php'>migrasi database</a> untuk membuat database dan tabel.</p>";
    exit;
}

// Cek koneksi ke database
echo "<h3>Koneksi ke Database:</h3>";
$conn_db = @mysqli_connect($host, $username, $password, $database);
if ($conn_db) {
    echo "<p style='color:green'>✓ Berhasil terhubung ke database '$database'.</p>";
} else {
    echo "<p style='color:red'>✗ Gagal terhubung ke database '$database': " . mysqli_connect_error() . "</p>";
    exit;
}

// Cek tabel-tabel
echo "<h3>Cek Tabel:</h3>";
$tables = [
    'admin', 'visi_misi', 'sambutan_kepsek', 'kurikulum', 'indikator_kelulusan',
    'prestasi', 'ekstrakurikuler', 'fasilitas', 'galeri', 'alumni', 'artikel', 'pengaturan'
];

$missing_tables = [];
foreach ($tables as $table) {
    $result = mysqli_query($conn_db, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color:green'>✓ Tabel '$table' ditemukan.</p>";
    } else {
        echo "<p style='color:red'>✗ Tabel '$table' tidak ditemukan.</p>";
        $missing_tables[] = $table;
    }
}

if (!empty($missing_tables)) {
    echo "<h3>Solusi:</h3>";
    echo "<p>Beberapa tabel tidak ditemukan. Jalankan <a href='../admin/migrate.php'>migrasi database</a> untuk membuat tabel-tabel yang diperlukan.</p>";
} else {
    echo "<h3>Kesimpulan:</h3>";
    echo "<p style='color:green'>✓ Semua tabel ditemukan dan database siap digunakan.</p>";
    echo "<p><a href='../admin/'>Kembali ke Admin Panel</a></p>";
}

// Tutup koneksi
mysqli_close($conn_server);
if ($conn_db) {
    mysqli_close($conn_db);
}
?> 