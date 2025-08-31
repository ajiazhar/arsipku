<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_arsip");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>