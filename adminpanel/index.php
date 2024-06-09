<?php
session_start();
require "../koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduk = mysqli_query($conn, "SELECT * FROM product");
$jumlahProduk = mysqli_num_rows($queryProduk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #0a6b4a;
        border-radius: 15px;
    }

    .summary-produk {
        background-color: #0a516b;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }

    .no-decoration::hover {
        color: blue;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Halo <?php echo $_SESSION['username']; ?></h2>

        <div class="container">
            <div class="row">
                <!-- bagian 1 -->
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-3">
                        <div class="summary">
                            <div class="row">
                                <!-- peletakan icon -->
                                <div class="col-6">
                                    <i class="fas fa-align-justify fa-7x text-black-50"></i>
                                </div>
                                <!-- peletakan teks -->
                                <div class="col-6 text-white">
                                    <h3 class="fs-2">Kategori</h3>
                                    <p class="fs-4"><?= $jumlahKategori; ?> Kategori</p>
                                    <a href="kategori.php" class="text-white no-decoration">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bagian 2 -->
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-3">
                        <div class="row">
                            <!-- peletakan icon -->
                            <div class="col-6">
                                <i class="fas fa-box fa-7x text-black-50"></i>
                            </div>
                            <!-- peletakan teks -->
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?= $jumlahProduk; ?> Kategori</p>
                                <a href="kategori.php" class="text-white no-decoration">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>