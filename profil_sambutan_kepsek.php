<?php
// Include database connection
include 'config/database.php';

// Ambil data sambutan kepsek
$query = "SELECT * FROM sambutan_kepsek WHERE id = 1";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan, tampilkan data default
if (!$data) {
    $data = [
        'nama_kepsek' => 'Ahmad Fauzi, S.Pd.I',
        'foto_kepsek' => 'kepsek.jpg',
        'sambutan' => 'Assalamu\'alaikum warahmatullahi wabarakatuh

Alhamdulillahirabbil\'alamin, segala puji bagi Allah SWT yang telah memberikan rahmat dan hidayah-Nya sehingga SDIT Luqman Al Hakim Sleman dapat terus berkembang dan memberikan kontribusi positif dalam dunia pendidikan Islam.

Sebagai Kepala Sekolah, saya mengucapkan selamat datang di website resmi SDIT Luqman Al Hakim Sleman. Website ini merupakan salah satu media informasi dan komunikasi antara sekolah dengan masyarakat luas, khususnya para orangtua dan calon orangtua siswa.

SDIT Luqman Al Hakim Sleman hadir dengan visi "Mewujudkan Generasi Qur\'ani yang Cerdas, Berakhlak Mulia, dan Mandiri". Kami berkomitmen untuk menyelenggarakan pendidikan yang tidak hanya fokus pada aspek akademik, tetapi juga pembentukan karakter islami yang kuat pada setiap siswa.

Dalam era globalisasi yang penuh tantangan ini, kami menyadari pentingnya mempersiapkan generasi yang tidak hanya cerdas secara intelektual, tetapi juga memiliki fondasi keimanan yang kuat, akhlak yang mulia, serta kemandirian yang akan menjadi bekal mereka di masa depan.

Kurikulum kami dirancang untuk mengintegrasikan nilai-nilai Al-Qur\'an dalam setiap aspek pembelajaran, sehingga siswa tidak hanya memahami ilmu pengetahuan umum, tetapi juga memahami dan mengamalkan ajaran Islam dalam kehidupan sehari-hari.

Kami mengajak seluruh orangtua untuk bermitra dengan sekolah dalam mendidik putra-putri kita. Dengan kerjasama yang baik antara sekolah dan orangtua, insyaAllah kita dapat mewujudkan generasi yang tidak hanya siap menghadapi tantangan zaman, tetapi juga menjadi pemimpin yang berakhlak mulia di masa depan.

Terima kasih atas kepercayaan yang telah diberikan kepada SDIT Luqman Al Hakim Sleman. Semoga Allah SWT senantiasa memberikan kemudahan dan keberkahan dalam setiap langkah kita mendidik generasi penerus bangsa.

Wassalamu\'alaikum warahmatullahi wabarakatuh'
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambutan Kepala Sekolah - SDIT Luqman Al Hakim Sleman</title>
    <link rel="shortcut icon" href="assets/images/x-icon.png" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icofont.min.css">
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader ending here -->


    <!-- scrollToTop start here -->
    <a href="#" class="scrollToTop yellow-color"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->


    <!-- menu-search-form start here -->
    <div class="menu-search-form">
        <form>
          <input type="text" name="search" placeholder="Search here...">
          <button type="submit"><i class="icofont-search"></i></button>
        </form>
    </div>
    <!-- menu-search-form ending here -->

    <!-- header section start here -->
    <?php include 'header.php'; ?>
    <!-- header section ending here -->

    <!-- Page Header Section Start Here -->
    <section class="page-header-section style-1">
        <div class="container">
            <div class="page-header-content">
                <div class="page-header-inner">
                    <div class="page-title">
                        <h2>Sambutan Kepala Sekolah</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Sambutan Kepala Sekolah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- course section start here -->
    <div class="course-single-section padding-tb section-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="main-part">
                        <div class="course-item">
                            <div class="course-inner">
                                <div class="course-content">
                                    <h3>Sambutan Kepala Sekolah</h3>
                                    <?php 
                                    // Konversi baris baru menjadi paragraf HTML
                                    $sambutan = nl2br($data['sambutan']);
                                    echo $sambutan;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-part">
                        <div class="course-side-detail">
                            <div class="csd-title">
                                <div class="csdt-left">
                                    <h4 class="mb-0">Kepala Sekolah</h4>
                                </div>
                            </div>
                            <div class="csd-content">
                                <div class="csdc-lists">
                                    <div class="text-center">
                                        <?php if (!empty($data['foto_kepsek'])): ?>
                                            <img src="assets/images/about/kepsek/<?php echo htmlspecialchars($data['foto_kepsek']); ?>" alt="Kepala Sekolah" class="img-fluid mb-4" style="max-width: 200px; border-radius: 5px;">
                                        <?php else: ?>
                                            <img src="assets/images/instructor/01.jpg" alt="Kepala Sekolah" class="img-fluid mb-4" style="max-width: 200px; border-radius: 5px;">
                                        <?php endif; ?>
                                        <h5><?php echo htmlspecialchars($data['nama_kepsek']); ?></h5>
                                        <p>Kepala SDIT Luqman Al Hakim Sleman</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- course section ending here -->

    <!-- footer -->
    <?php include 'footer.php'; ?>
    <!-- footer -->



    <!-- All Scripts -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/progress.js"></script>
    <script src="assets/js/lightcase.js"></script>
    <script src="assets/js/counter-up.js"></script>
    <script src="assets/js/isotope.pkgd.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html> 