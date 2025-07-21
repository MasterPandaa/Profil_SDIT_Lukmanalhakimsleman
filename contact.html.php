<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
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
    <a href="#" class="scrollToTop"><i class="icofont-rounded-up"></i></a>
    <!-- scrollToTop ending here -->


    <!-- header section start here -->
    <?php include 'header.php'; ?>
    <!-- header section ending here -->


    <!-- Page Header section start here -->
    <div class="pageheader-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pageheader-content text-center">
                        <h2>Hubungi Kami</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header section ending here -->


    <!-- Contact Us Section Start Here -->
    <div class="contact-section padding-tb">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Hubungi Kami</span>
                <h2 class="title">Silakan Menghubungi Kami Jika Ada Pertanyaan</h2>
            </div>
            <div class="section-wrapper">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="contact-item">
                            <div class="contact-thumb">
                                <img src="assets/images/contact/icon/01.png" alt="contact">
                            </div>
                            <div class="contact-content">
                                <h6 class="title">Alamat Sekolah</h6>
                                <p>Jl. Palagan Tentara Pelajar No.52, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="contact-item">
                            <div class="contact-thumb">
                                <img src="assets/images/contact/icon/02.png" alt="contact">
                            </div>
                            <div class="contact-content">
                                <h6 class="title">Nomor Telepon</h6>
                                <p>+62 857-4725-5761 <br> +62 274-889-766</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="contact-item">
                            <div class="contact-thumb">
                                <img src="assets/images/contact/icon/01.png" alt="contact">
                            </div>
                            <div class="contact-content">
                                <h6 class="title">Email Sekolah</h6>
                                <p>info@luqmanalhakim.sch.id <br> admin@luqmanalhakim.sch.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Us Section Ending Here -->


    <!-- Contact Us Section Start Here -->
    <div class="contact-section padding-tb pb-0">
        <div class="container">
            <div class="section-header text-center">
                <span class="subtitle">Kirim Pesan</span>
                <h2 class="title">Silakan Mengisi Form di Bawah Ini</h2>
            </div>
            <div class="section-wrapper">
                <form class="contact-form" action="contact.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Lengkap *" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Anda *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" placeholder="Nomor Telepon *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subjek Pesan *" required>
                    </div>
                    <div class="form-group w-100">
                        <textarea name="message" rows="8" placeholder="Pesan Anda *" required></textarea>
                    </div>
                    <div class="form-group w-100 text-center">
                        <button class="lab-btn" type="submit"><span>Kirim Pesan</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact Us Section Ending Here -->


    <!-- Google Map Section Start Here -->
    <div class="map-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="map-area">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1622426128483!2d110.39776891477862!3d-7.7758193944398975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59b2d4729729%3A0xac4d7b5fcf34f8e4!2sSDIT%20Luqman%20Al%20Hakim%20Sleman!5e0!3m2!1sen!2sid!4v1652345678901!5m2!1sen!2sid" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Google Map Section Ending Here -->

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