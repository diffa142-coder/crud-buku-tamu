<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

// Cek role user
$role = $_SESSION['role'] ?? '';
$username = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zie BukuTamu</title>

    <!-- Font Awesome -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- SB Admin 2 -->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Logo / Nama Aplikasi -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="index.php">

                <div class="sidebar-brand-icon">
                    <i class="fas fa-school"></i>
                </div>

                <div class="sidebar-brand-text mx-3">
                    Zie BukuTamu
                </div>

            </a>

            <hr class="sidebar-divider my-0">


            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <!-- Buku Tamu khusus Operator -->
            <?php if ($role === 'operator') : ?>

                <li class="nav-item">
                    <a class="nav-link" href="buku-tamu.php">
                        <i class="fas fa-fw fa-book-open"></i>
                        <span>Buku Tamu</span>
                    </a>
                </li>

            <?php endif; ?>


            <!-- Laporan untuk Admin dan Operator -->
            <li class="nav-item">
                <a class="nav-link" href="laporan.php">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>


            <!-- User khusus Admin -->
            <?php if ($role === 'admin') : ?>

                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>User</span>
                    </a>
                </li>

            <?php endif; ?>


            <hr class="sidebar-divider d-none d-md-block">


            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-power-off"></i>
                    <span>Logout</span>
                </a>
            </li>


            <hr class="sidebar-divider d-none d-md-block">


            <!-- Sidebar Toggle -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggleTop"
                        class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">

                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control bg-light border-0 small"
                                placeholder="Search for..."
                                aria-label="Search">

                            <div class="input-group-append">

                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>

                            </div>

                        </div>

                    </form>


                    <!-- Informasi User -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link dropdown-toggle"
                                href="#"
                                id="userDropdown"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">

                                    <?= htmlspecialchars($username); ?>

                                    (<?= htmlspecialchars($role); ?>)

                                </span>

                                <img
                                    class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">

                            </a>


                            <!-- Dropdown User -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-item-text">

                                    <strong>
                                        <?= htmlspecialchars($username); ?>
                                    </strong>

                                    <br>

                                    <small>
                                        Role:
                                        <?= htmlspecialchars($role); ?>
                                    </small>

                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="logout.php">

                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                                    Logout

                                </a>

                            </div>

                        </li>

                    </ul>

                </nav>

                <!-- End Topbar -->