<?php

require "session.php";
require "../koneksi.php";

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori page</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <!-- Navbar -->
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../adminpanel/index.php" class="no-decoration text-muted"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori" class="mb-1">Kategori :</label>
                    <input type="text" name="kategori" id="kategori" placeholder="Input nama kategori" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_kategori">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan_kategori'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                $queryExist = mysqli_query($conn, "SELECT nama FROM kategori WHERE nama = '$kategori'; ");
                $jumlahKategoriBaru = mysqli_num_rows($queryExist);

                if ($jumlahKategoriBaru > 0) {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Kategori sudah tersedia !
                    </div>
            <?php
                } else {
                    $querySimpan = mysqli_query($conn, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                    if ($querySimpan) {
            ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Data berhasil tersimpan
                        </div>

                        <meta http-equiv="refresh" content="2; url=kategori.php" />
            <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }

            ?>
        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        if ($jumlahKategori == 0) {
                ?>
                            <tr>
                                <td colspan='3' class="text-center">Tidak ada data pada kategori</td>
                            </tr>"
                <?php
                        } else {
                            $number = 1;
                            while ($data = mysqli_fetch_array($queryKategori)) {
                ?>
                            <tr>
                                <td><?= $number; ?> </td>
                                <td><?= $data['nama']; ?></td>
                                <td>
                                    <a href="kategori-detail.php?q=<?= $data['id']; ?>" class="btn btn-info">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                <?php
                                $number++;
                            }
                        }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>