<?php

use function PHPSTORM_META\map;

require "session.php";
require "../koneksi.php";

$id =  $_GET['q'];

$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id='$id'");
$data = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail kategori</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/fontawesome.min.css">
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Detail kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?= $data['nama']; ?>">
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
            if (isset($_POST['editBtn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                if ($data['nama'] == $kategori) {
            ?>
                    <meta http-equiv="refresh" content="0; url=kategori.php" />
            <?php
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama = '$kategori'");
                    $jumlahData = mysqli_num_rows($query);

                    if ($jumlahData > 0) {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori sudah tersedia !
                        </div>
            <?php
                    } else {
                        $querySimpan = mysqli_query($conn, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");

                        if ($querySimpan) {
            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Data berhasil di update
                            </div>

                            <meta http-equiv="refresh" content="2; url=kategori.php" />
            <?php
                        } else {
                            echo mysqli_error($conn);
                        }
                    } 
                }
            }


            if (isset($_POST['deleteBtn'])) {
                $queryCheck = mysqli_query($conn, "SELECT * FROM product WHERE kategori_id = '$id' ");
                $dataCount = mysqli_num_rows($queryCheck);

                if( $dataCount > 0 ) {
            ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Kategori tidak bisa dihapus karena sudah digunakkan di produk
                </div>
            <?php
            die();
                }
                
                $queryDelete = mysqli_query($conn, "DELETE FROM kategori WHERE id='$id' ");

                if($queryDelete) {
            ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Data berhasil di hapus
                    </div>

                    <meta http-equiv="refresh" content="2; url=kategori.php" />
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