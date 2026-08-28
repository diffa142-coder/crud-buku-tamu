<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require_once('koneksi.php');
require_once('function.php');

$p_awal = '';
$p_akhir = '';
$buku_tamu = [];

// Jika tombol Tampilkan ditekan
if (isset($_POST['tampilkan'])) {

    $p_awal = $_POST['p_awal'];
    $p_akhir = $_POST['p_akhir'];

    // Cek agar tanggal awal tidak lebih besar dari tanggal akhir
    if ($p_awal <= $p_akhir) {

        $buku_tamu = query(
            "SELECT * FROM buku_tamu
            WHERE tanggal BETWEEN '$p_awal' AND '$p_akhir'
            ORDER BY tanggal DESC"
        );
    }
}

include_once('templates/header.php');
?>

<style>

/* ============================= */
/* TAMPILAN SAAT CETAK */
/* ============================= */

@media print {

    /* Sembunyikan sidebar */
    #accordionSidebar {
        display: none !important;
    }

    /* Sembunyikan topbar */
    .topbar {
        display: none !important;
    }

    /* Sembunyikan semua tombol */
    .btn {
        display: none !important;
    }

    /* Sembunyikan form periode */
    .row {
        display: none !important;
    }

    /* Sembunyikan footer */
    footer {
        display: none !important;
    }

    /* Hilangkan margin dan padding */
    #content-wrapper,
    #content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    .container-fluid {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Hilangkan shadow card */
    .card {
        box-shadow: none !important;
        border: none !important;
    }

    /* Judul laporan */
    h1 {
        text-align: center;
        color: black !important;
        margin-bottom: 20px;
    }

    /* Judul tabel */
    .card-header {
        text-align: center;
        color: black !important;
    }

    /* Tabel */
    table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 12px !important;
    }

    table th,
    table td {
        border: 1px solid black !important;
        padding: 8px !important;
        color: black !important;
    }

    table th {
        background-color: #eeeeee !important;
    }

    /* Sembunyikan fitur DataTables */
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        display: none !important;
    }

    /* Hilangkan background */
    body {
        background: white !important;
    }

}


/* ============================= */
/* TAMPILAN NORMAL */
/* ============================= */

@media screen {

    .laporan-print {
        display: none;
    }

}

</style>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        Laporan Tamu
    </h1>


    <!-- Form Periode -->
    <div class="row mx-auto d-flex justify-content-center">

        <div class="col-xl-7 col-md-9 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <form method="post" action="">

                        <div class="form-row align-items-center">

                            <div class="col-auto">

                                <div class="font-weight-bold text-primary text-uppercase mb-1">
                                    Periode
                                </div>

                            </div>


                            <div class="col-auto">

                                <input
                                    type="date"
                                    class="form-control mb-2"
                                    id="p_awal"
                                    name="p_awal"
                                    value="<?= htmlspecialchars($p_awal); ?>"
                                    required>

                            </div>


                            <div class="col-auto">

                                <div class="font-weight-bold text-primary mb-1">
                                    s.d
                                </div>

                            </div>


                            <div class="col-auto">

                                <input
                                    type="date"
                                    class="form-control mb-2"
                                    id="p_akhir"
                                    name="p_akhir"
                                    value="<?= htmlspecialchars($p_akhir); ?>"
                                    required>

                            </div>


                            <div class="col-auto">

                                <button
                                    type="submit"
                                    name="tampilkan"
                                    class="btn btn-primary mb-2">

                                    <i class="fas fa-search"></i>
                                    Tampilkan

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    <!-- Tabel Laporan -->
    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <span class="font-weight-bold text-primary">
                Tabel Histori Tamu
            </span>


            <!-- Tombol Cetak -->
            <?php if (isset($_POST['tampilkan']) && count($buku_tamu) > 0) : ?>

                <button
                    onclick="window.print()"
                    class="btn btn-primary">

                    <i class="fas fa-print"></i>
                    Cetak

                </button>

            <?php endif; ?>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table
                    class="table table-bordered"
                    id="dataTable"
                    width="100%"
                    cellspacing="0">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. Telp/HP</th>
                            <th>Bertemu Dengan</th>
                            <th>Kepentingan</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (isset($_POST['tampilkan'])) : ?>


                            <?php if ($p_awal <= $p_akhir) : ?>


                                <?php if (count($buku_tamu) > 0) : ?>

                                    <?php $no = 1; ?>


                                    <?php foreach ($buku_tamu as $tamu) : ?>

                                        <tr>

                                            <td>
                                                <?= $no++; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['tanggal']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['nama_tamu']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['alamat']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['no_hp']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['bertemu']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($tamu['kepentingan']); ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>


                                <?php else : ?>

                                    <tr>

                                        <td colspan="7" class="text-center">

                                            Tidak ada data tamu pada periode tersebut.

                                        </td>

                                    </tr>

                                <?php endif; ?>


                            <?php else : ?>

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center text-danger">

                                        Tanggal awal tidak boleh lebih besar
                                        dari tanggal akhir.

                                    </td>

                                </tr>

                            <?php endif; ?>


                        <?php else : ?>

                            <tr>

                                <td colspan="7" class="text-center">

                                    Silakan pilih periode tanggal terlebih dahulu.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->


<?php
include_once('templates/footer.php');
?>