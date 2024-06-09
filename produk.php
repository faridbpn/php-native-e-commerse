<?php
require "koneksi.php";

// get kategori
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

// get produk by nama/keyword
if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $queryProduk = mysqli_query($conn, "SELECT * FROM product WHERE nama LIKE '%$keyword%'");
}

// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama='$_GET[kategori]' ");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);

    $queryProduk = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id='$kategoriId[id]'");
}

// get produk default
else {
    $queryProduk = mysqli_query($conn, "SELECT * FROM product");
}

$countData = mysqli_num_rows($queryProduk);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Onlline | Produk</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <!-- kiri -->
            <div class="col-lg-3 mb-5">
                <h3 class="text-center">Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a class="no-decoration" href="produk.php?kategori=<?= $kategori['nama']; ?>">
                            <li class="list-group-item"><?= $kategori['nama']; ?></li>
                        </a>
                    <?php }; ?>

                </ul>
            </div>
            <!-- kanan -->
            <div class="col-lg-9">
                <h3 class="text-center mb-4">Produk</h3>
                <div class="row">
                    <?php 
                        if($countData<1) {
                    ?>
                        <h4 class="text-center my-5">Produk yang anda cari tidak tersedia</h4>
                    <?php
                        }
                    ?>

                    <?php while($produk = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-md-4">
                        <div class="card h-20 mb-4">
                            <div class="image-box">
                                <img src="image/<?= $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= $produk['nama']; ?></h4>
                                <p class="card-text text-truncate"><?= $produk['detail']; ?></p>
                                <p class="card-text text-harga"><?= $produk['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?= $produk['nama']; ?>" class="btn btn-primary warna2 text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
     <?php
     require "footer.php";
     ?>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>