<?php
require_once('koneksi.php');
require_once('function.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_user($id) > 0) {
        header("Location: users.php?hapus=sukses");
        exit;
    } else {
        header("Location: users.php?hapus=gagal");
        exit;
    }
}