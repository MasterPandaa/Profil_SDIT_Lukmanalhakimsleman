<?php
// Include database connection
include 'config/database.php';

// Ambil data prestasi
$query = "SELECT * FROM prestasi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
$prestasis = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $prestasis[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi - SDIT Luqman Al Hakim Sleman</title>
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
                        <h2>Prestasi</h2>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Prestasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Header Section Ending Here -->

    <!-- Achievement section start here -->
    <div class="achievement-section padding-tb section-bg">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Prestasi Membanggakan</span>
                <h2 class="title">Prestasi SDIT Luqman Al Hakim Sleman</h2>
                <p>Berikut adalah berbagai prestasi yang telah diraih oleh siswa-siswi SDIT Luqman Al Hakim Sleman</p>
            </div>
            <div class="section-wrapper">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                    <?php if (count($prestasis) > 0): ?>
                        <?php foreach ($prestasis as $prestasi): ?>
                            <div class="col">
                                <div class="achievement-item">
                                    <div class="achievement-inner">
                                        <div class="achievement-thumb">
                                            <?php if (!empty($prestasi['foto'])): ?>
                                                <img src="assets/images/prestasi/<?php echo htmlspecialchars($prestasi['foto']); ?>" alt="<?php echo htmlspecialchars($prestasi['judul']); ?>">
                                            <?php else: ?>
                                                <img src="assets/images/achive/01.png" alt="achievement">
                                            <?php endif; ?>
                                            <div class="achievement-badge">
                                                <span><?php echo htmlspecialchars($prestasi['tingkat']); ?></span>
                                            </div>
                                        </div>
                                        <div class="achievement-content">
                                            <h4><?php echo htmlspecialchars($prestasi['judul']); ?></h4>
                                            <p><?php echo substr(strip_tags($prestasi['deskripsi']), 0, 100); ?>...</p>
                                            <div class="achievement-date">
                                                <i class="icofont-calendar"></i> <?php echo date('d F Y', strtotime($prestasi['tanggal'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Belum ada data prestasi.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Achievement section ending here -->

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