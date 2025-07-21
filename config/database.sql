-- Database: db_sdit_lukmanalhakimsleman

-- Struktur tabel untuk tabel `admin`
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `admin`
INSERT INTO `admin` (`id`, `username`, `password`, `nama`, `email`, `foto`, `last_login`) VALUES
(1, 'admin', '$2y$10$EfVuZzSzXFsUnRc0gJdNcOUcZxXdmAZQMC8pHjz.HRFQi9WnJUKlO', 'Administrator', 'admin@example.com', NULL, NULL);

-- Struktur tabel untuk tabel `visi_misi`
CREATE TABLE `visi_misi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `visi_misi`
INSERT INTO `visi_misi` (`id`, `visi`, `misi`, `updated_at`) VALUES
(1, 'Menjadi sekolah Islam terbaik yang menghasilkan generasi Qur''ani yang berakhlak mulia, cerdas, dan mandiri', '<ol><li>Menyelenggarakan pendidikan Islam yang mengintegrasikan aspek keimanan, keilmuan, dan amal sholeh</li><li>Menerapkan pembiasaan akhlak mulia dalam kehidupan sehari-hari</li><li>Mengembangkan pembelajaran yang aktif, kreatif, dan menyenangkan</li><li>Membekali peserta didik dengan keterampilan hidup (life skill)</li></ol>', '2023-01-01 07:00:00');

-- Struktur tabel untuk tabel `sambutan_kepsek`
CREATE TABLE `sambutan_kepsek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kepsek` varchar(100) NOT NULL,
  `foto_kepsek` varchar(255) DEFAULT NULL,
  `sambutan` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `sambutan_kepsek`
INSERT INTO `sambutan_kepsek` (`id`, `nama_kepsek`, `foto_kepsek`, `sambutan`, `updated_at`) VALUES
(1, 'Nama Kepala Sekolah', 'kepsek.jpg', 'Assalamualaikum Wr. Wb.\r\n\r\nPuji syukur kami panjatkan ke hadirat Allah SWT atas limpahan rahmat dan karunia-Nya sehingga website SDIT Luqman Al Hakim Sleman dapat hadir di tengah-tengah kita.\r\n\r\nWebsite ini merupakan sarana informasi dan komunikasi bagi seluruh warga sekolah dan masyarakat. Melalui website ini, kami berharap dapat memberikan informasi yang aktual dan terpercaya tentang kegiatan dan program sekolah kami.\r\n\r\nSDIT Luqman Al Hakim Sleman berkomitmen untuk terus meningkatkan kualitas pendidikan yang berbasis Al-Qur''an dan mempersiapkan generasi yang berakhlak mulia, cerdas, dan mandiri.\r\n\r\nWassalamualaikum Wr. Wb.', '2023-01-01 07:00:00');

-- Struktur tabel untuk tabel `kurikulum`
CREATE TABLE `kurikulum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `konten` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `kurikulum`
INSERT INTO `kurikulum` (`id`, `judul`, `deskripsi`, `konten`, `updated_at`) VALUES
(1, 'Kurikulum SDIT Luqman Al Hakim Sleman', 'Kurikulum yang diterapkan di SDIT Luqman Al Hakim Sleman merupakan perpaduan antara Kurikulum Nasional dan Kurikulum Kekhasan Sekolah Islam', '<h4>Kurikulum Nasional</h4>\r\n<p>SDIT Luqman Al Hakim Sleman menerapkan Kurikulum Nasional sesuai dengan ketentuan pemerintah yang mencakup mata pelajaran wajib seperti Matematika, Bahasa Indonesia, IPA, IPS, dan lainnya.</p>\r\n\r\n<h4>Kurikulum Kekhasan</h4>\r\n<p>Sebagai sekolah Islam, kami memiliki kurikulum kekhasan yang meliputi:</p>\r\n<ul>\r\n<li>Tahfidz Al-Qur''an</li>\r\n<li>Bahasa Arab</li>\r\n<li>Pendidikan Akhlak</li>\r\n<li>Praktik Ibadah</li>\r\n</ul>', '2023-01-01 07:00:00');

-- Struktur tabel untuk tabel `indikator_kelulusan`
CREATE TABLE `indikator_kelulusan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `konten` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `indikator_kelulusan`
INSERT INTO `indikator_kelulusan` (`id`, `judul`, `deskripsi`, `konten`, `updated_at`) VALUES
(1, 'Indikator Kelulusan SDIT Luqman Al Hakim Sleman', 'Standar kelulusan yang diharapkan dari siswa SDIT Luqman Al Hakim Sleman', '<h4>Aspek Keagamaan</h4>\r\n<ul>\r\n<li>Hafal minimal 2 juz Al-Qur''an</li>\r\n<li>Mampu melaksanakan ibadah wajib dengan baik dan benar</li>\r\n<li>Memiliki akhlak yang baik dalam kehidupan sehari-hari</li>\r\n</ul>\r\n\r\n<h4>Aspek Akademik</h4>\r\n<ul>\r\n<li>Mencapai nilai minimal sesuai standar kelulusan nasional</li>\r\n<li>Mampu berkomunikasi dengan baik</li>\r\n<li>Memiliki kemampuan berpikir kritis dan kreatif</li>\r\n</ul>\r\n\r\n<h4>Aspek Sosial</h4>\r\n<ul>\r\n<li>Mampu bekerja sama dalam tim</li>\r\n<li>Memiliki kepedulian terhadap lingkungan</li>\r\n<li>Memiliki jiwa kepemimpinan</li>\r\n</ul>', '2023-01-01 07:00:00');

-- Struktur tabel untuk tabel `prestasi`
CREATE TABLE `prestasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL,
  `tingkat` enum('Sekolah','Kecamatan','Kabupaten','Provinsi','Nasional','Internasional') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `ekstrakurikuler`
CREATE TABLE `ekstrakurikuler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `jadwal` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `fasilitas`
CREATE TABLE `fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `galeri`
CREATE TABLE `galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `kategori` enum('Kegiatan Pembelajaran','Kegiatan Keagamaan','Ekstrakurikuler','Fasilitas','Lainnya') NOT NULL DEFAULT 'Lainnya',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `alumni`
CREATE TABLE `alumni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `testimoni` text DEFAULT NULL,
  `pendidikan_lanjutan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `artikel`
CREATE TABLE `artikel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `penulis` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('Berita','Pengumuman','Artikel','Kegiatan') NOT NULL DEFAULT 'Berita',
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Struktur tabel untuk tabel `pengaturan`
CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_situs` varchar(100) NOT NULL DEFAULT 'SDIT Luqman Al Hakim Sleman',
  `logo` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal untuk tabel `pengaturan`
INSERT INTO `pengaturan` (`id`, `nama_situs`, `logo`, `alamat`, `telepon`, `email`, `facebook`, `instagram`, `youtube`, `footer_text`, `updated_at`) VALUES
(1, 'SDIT Luqman Al Hakim Sleman', 'logo.png', 'Jl. Contoh No. 123, Sleman, Yogyakarta', '08123456789', 'info@luqmanalhakim.sch.id', 'https://facebook.com/sditluqmanalhakim', 'https://instagram.com/sditluqmanalhakim', 'https://youtube.com/sditluqmanalhakim', '© 2023 SDIT Luqman Al Hakim Sleman. All Rights Reserved.', '2023-01-01 07:00:00'); 