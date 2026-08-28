<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

require_once('koneksi.php');
require_once('function.php');

$id_user = $_GET['id'];

$data = query("SELECT * FROM users WHERE id_user = '$id_user'")[0];
?>

<?php include_once('templates/header.php'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Ganti Password</h1>

    <div class="card shadow mb-4">
        <div class="card-body">

            <form method="post">

                <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text"
                        class="form-control"
                        value="<?= $data['username']; ?>"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password"
                        name="password"
                        class="form-control"
                        required>
                </div>

                <button type="submit" name="ubah_password" class="btn btn-primary">
                    Simpan
                </button>

                <a href="users.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

<?php include_once('templates/footer.php'); ?>