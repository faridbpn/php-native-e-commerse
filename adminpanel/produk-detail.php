<?php

use function PHPSTORM_META\map;

require "session.php";
require "../koneksi.php";

$id =  $_GET['q'];

$query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id WHERE  a.id='$id'");
$data = mysqli_fetch_array($query);

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Produk Detail</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<style>
        form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail Product</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                    <!-- nama -->
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" value="<?= $data['nama']; ?>" class="form-control" autocomplete="off" required>
                    </div>
                    <!-- kategori -->
                    <div>
                        <label for="kategori">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="<?= $data['kategori_id']; ?>"> <?= $data['nama_kategori']; ?> </option>
                            <?php
                                while($dataKategori = mysqli_fetch_array($queryKategori)) {
                            ?>
                                <option value="<?= $dataKategori['id']; ?>"><?= $dataKategori['nama']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                     <!-- harga -->
                     <div>
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?= $data['harga']; ?>" required>
                    </div>
                    <!-- foto -->
                    <div>
                        <label for="currentFoto">Foto Produk Sekarang</label>
                        <img src="../image/<?= $data['foto']; ?>" alt="" width="300px" height="300px">
                    </div>
                    <div>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                    <!-- detail -->
                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" class="form-control">
                            <?= $data['detail']; ?>
                        </textarea>
                    </div> 
                    <!-- ketersediaan stok -->
                    <div>
                        <label for="ketersediaan_stok">Ketersediaan Stok</label>
                        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                            <option value="<?= $data['ketersediaan_stok'] ?>"><?= $data['ketersediaan_stok']; ?></option>
                            <?php
                                if( $data['ketersediaan_stok'] == 'tersedia' ) {
                            ?>
                                 <option value="habis">Habis</option>
                            <?php
                                } else {
                            ?>
                                <option value="tersedia">Tersedia</option>
                            <?php
                                }
                            ?>
                            
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                        <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
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
                             Nama, Kategori dan Harga wajib diisi
                        </div>
            <?php
                    } else {
                        $queryUpdate = mysqli_query($conn, "UPDATE product SET kategori_id = '$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id ='$id' ");

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
                                     File wajib bertipe jpg, png atau gif
                                </div>
            <?php
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                    $queryUpdate = mysqli_query($conn, "UPDATE product SET foto='$new_name' WHERE id='$id' ");

                                    if( $queryUpdate ) {
            ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                         Produk berhasil diupdate
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                                    } else {
                                        echo mysqli_error($conn);
                                    }
                                }
                            }
                        }
                    }
                }

                if( isset($_POST['hapus']) ) {
                    $queryHapus = mysqli_query($conn, "DELETE FROM product WHERE id='$id' ");

                    if( $queryHapus ) {
            ?>
                       <div class="alert alert-primary mt-3" role="alert">
                            Produk berhasil di hapus
                       </div>

                       <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                    }
                }
            ?>
        </div>
    </div>




    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome-free-6.5.2-web/js/all.min.js"></script>

</body>

</html>