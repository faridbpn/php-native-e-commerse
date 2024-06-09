<?php

require "session.php";
require "../koneksi.php";

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id ");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

function generateRandomString($length = 10) {
    $characthers = '0123456789nvasldnvalknevallkndlknselkka';
    $characthersLength = strlen($characthers);
    $randomString = '';
    for ( $i = 0; $i < $length; $i++ ) {
        $randomString .= $characthers[rand(0, $characthersLength - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$jumlahProduk</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <!-- Navbar -->
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../adminpanel/index.php" class="no-decoration text-muted"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>

          <!-- sabar bang tambah produk -->
            <div class="my-5 col-12 col-md-6">
                <h3>Tambah Produk</h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <!-- nama -->
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                    </div>
                    <!-- kategori -->
                    <div>
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">Pilih satu</option>
                            <?php
                                while($data = mysqli_fetch_array($queryKategori)) {
                            ?>
                                <option value="<?= $data['id']; ?>"><?= $data['nama']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <!-- harga -->
                    <div>
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" required>
                    </div>
                    <!-- foto -->
                    <div>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                    <!-- detail -->
                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" class="form-control"></textarea>
                    </div>
                    <!-- ketersediaan stok -->
                    <div>
                        <label for="ketersediaan_stok">Ketersediaan Stok</label>
                        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                            <option value="tersedia">Tersedia</option>
                            <option value="habis">Habis</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                    </div>
                </form>

                <?php
                    if( isset($_POST['simpan']) ) {
                        $nama = htmlspecialchars($_POST['nama']);
                        $kategori = htmlspecialchars($_POST['kategori']);
                        $harga = htmlspecialchars($_POST['harga']);
                        $detail = htmlspecialchars($_POST['detail']);
                        $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                        $target_dir = "../image/";
                        $nama_file = basename($_FILES["foto"]["name"]);
                        $target_file = $target_dir . $nama_file;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        $image_size = $_FILES["foto"]["size"];
                        $random_name = generateRandomString(20);
                        $new_name = $random_name . "." . $imageFileType;

                        if( $nama == '' || $kategori == '' || $harga == '' ) {
                ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama, Kategori ,dan Harga Wajib Diisi
                        </div>
                <?php
                        } else {
                            if( $nama_file = '' ) {
                                if( $image_size > 500000 ) {
                ?>
                                 <div class="alert alert-warning mt-3" role="alert">
                                    File tidak boleh lebih dari 500 kb
                                 </div>
                <?php
                                } else {
                                    if( $imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File wajib bernilai jpg, png, dan gif
                                    </div>
                <?php
                                    }
                                }
                            } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        } 

                        // query insert ke database
                        $queryTambah = mysqli_query($conn, "INSERT INTO product (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");

                        if( $queryTambah ) {
                ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Data berhasil tersimpan
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php" />
                <?php
                        } else {
                            echo mysqli_error($conn);
                        }
                    } 
                ?>
            </div>

    </div>

    <div class="mt-3 mb-5">
        <h2>List Produk</h2>

        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Ketersediaan Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if($jumlahProduk == 0) {
                    ?>
                        <tr>
                            <td colspan='6' class="text-center">Tidak ada data pada produk</td>
                        </tr>
                    <?php
                        }
                        else {
                            $jumlah = 1;
                            while( $data=mysqli_fetch_array($query) ) {
                    ?>
                            <tr>
                                <td><?= $jumlah; ?></td>
                                <td><?= $data['nama']; ?></td>
                                <td><?= $data['nama_kategori']; ?></td>
                                <td><?= $data['harga']; ?></td>
                                <td><?= $data['ketersediaan_stok']; ?></td>
                                <td>
                                    <a href="produk-detail.php?q=<?= $data['id']; ?>" class="btn btn-info">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                            $jumlah++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


  







    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>
</body>

</html>