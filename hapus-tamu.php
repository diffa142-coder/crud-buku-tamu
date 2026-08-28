<?php
session_start();

if ($_SESSION['role'] != 'operator') {
    header("Location: index.php");
    exit;
}

require_once('koneksi.php');
require_once('function.php');
// jika ada id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_tamu($id) > 0) {
        header("Location: buku-tamu.php?hapus=sukses");
        exit;
    } else {
        header("Location: buku-tamu.php?hapus=gagal");
        exit;
    }
}
