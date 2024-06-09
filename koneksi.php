<?php
    $conn = mysqli_connect("localhost", "farid", "test1", "cara_fajar");

    // check connnection bang
    if(mysqli_connect_error()) {
        echo "failed to connect to MYSQL" . mysqli_connect_error();
        exit();
    }
?>