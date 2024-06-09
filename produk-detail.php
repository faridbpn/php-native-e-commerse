<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($conn, "SELECT * FROM product WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$queryProdukTerkait = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]'  LIMIT 4 ");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko onlline | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <img src="image/<?= $produk['foto']; ?>" alt="" class="w-100">
                </div>
                <div class="col-md-6 offset-lg-1">
                    <h1><?= $produk['nama']; ?></h1>
                    <p>
                        <?= $produk['detail']; ?>
                    </p>
                    <p class="text-harga">
                        Rp <?= $produk['harga']; ?>
                    </p>
                    <p class="">Status Ketersediaan : <strong><?= $produk['ketersediaan_stok']; ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- produk terkait -->
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="produk-detail.php?nama=<?= $data['nama']; ?>">
                            <img src="image/<?= $data['foto']; ?>" alt="" class="img-fluid img-thumbnail produk-terkait-img">
                        </a>
                    </div>
                <?php } ?>
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