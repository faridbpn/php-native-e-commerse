<?php
require "koneksi.php";

$queryProduk = mysqli_query($conn, "SELECT id, nama, harga, foto, detail FROM product LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodolan Home</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner d-flex align-content-center">
        <div class="container text-center text-white mt-5">
            <h1>Toko Online Fashion</h1>
            <h3>Mau Berburu Apa?</h3>
            <div class="col-8 offset-md-2 offset-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna2 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- kategori terlaris -->
    <div class="container-fluid">
        <div class="container text-center mt-3">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="list-kategori kategori-baju-pria justify-content-center align-content-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?=baju pria">Baju Pria</a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="list-kategori kategori-baju-wanita justify-content-center align-content-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?=baju wanita">Baju Wanita</a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="list-kategori kategori-sepatu justify-content-center align-content-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?=baju sepatu">Sepatu</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kamu -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis beatae aliquid esse quisquam officiis expedita laboriosam, provident maiores est laudantium debitis doloribus adipisci aliquam architecto sit hic, enim porro molestias?
            </p>
        </div>
    </div>

    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
                    <!-- 1 -->
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?= $data['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= $data['nama']; ?></h4>
                                <p class="card-text text-truncate"><?= $data['detail']; ?></p>
                                <p class="card-text text-harga">Rp <?= $data['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?= $data['nama']; ?>" class="btn btn-primary warna2 text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div>
                <button class="btn btn-outline-warning mt-3 mb-4" href="produk.php">Lihat Semua</button>
            </div>
        </div>

        <!-- footer -->
         <?php require "footer.php"; ?>

        <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
        <script src="fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>