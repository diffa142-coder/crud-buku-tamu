<?php
session_start();

if ($_SESSION['role'] != 'operator') {
    header("Location: index.php");
    exit;
}

require_once('koneksi.php');
require_once('function.php');

// cek apakah id_tamu dikirim melalui URL
if (isset($_GET['id'])) {

    $id_tamu = $_GET['id'];

    // ambil data tamu berdasarkan id
    $tamu = query("SELECT * FROM buku_tamu WHERE id_tamu = '$id_tamu'");

    // ambil data pertama
    $tamu = $tamu[0];
}

if (isset($_POST['simpan'])) {

    if (ubah($_POST) > 0) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'buku-tamu.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
            </script>";
    }
}

include_once('templates/header.php');
?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Data Tamu</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Edit Data Tamu
            </h6>
        </div>

        <div class="card-body">

                        <form method="post" action="" enctype="multipart/form-data">

                <input type="hidden" name="id_tamu" value="<?= $tamu['id_tamu']; ?>">
                <input type="hidden" name="gambarLama" value="<?= $tamu['gambar']; ?>">

                <div class="form-group">
                    <label>Nama Tamu</label>
                    <input type="text"
                        class="form-control"
                        name="nama_tamu"
                        value="<?= $tamu['nama_tamu']; ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea
                        class="form-control"
                        name="alamat"><?= $tamu['alamat']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text"
                        class="form-control"
                        name="no_hp"
                        value="<?= $tamu['no_hp']; ?>">
                </div>

                <div class="form-group">
                    <label>Bertemu Dengan</label>
                    <input type="text"
                        class="form-control"
                        name="bertemu"
                        value="<?= $tamu['bertemu']; ?>">
                </div>

                <div class="form-group">
                    <label>Kepentingan</label>
                    <input type="text"
                        class="form-control"
                        name="kepentingan"
                        value="<?= $tamu['kepentingan']; ?>">
                </div>

                <div class="form-group">
                    <label>Gambar Foto</label><br>
                    <img src="assets/upload_gambar/<?= $tamu['gambar']; ?>" alt="" width="150"><br><br>
                    <input type="file" class="form-control-file" name="gambar">
                </div>

                <button type="submit" name="simpan" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="buku-tamu.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

<?php
include_once('templates/footer.php');
?>