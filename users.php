<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

require_once('koneksi.php');
require_once('function.php');

// jika tombol ganti password ditekan
if (isset($_POST['ganti_password'])) {
    if (ganti_password($_POST) > 0) {
        header("Location: users.php?sukses=1");
        exit;
    } else {
        header("Location: users.php?gagal=1");
        exit;
    }
}

// generate kode user otomatis
$query = mysqli_query($koneksi, "SELECT max(id_user) as kodeTerbesar FROM users");
$data = mysqli_fetch_array($query);
$kodeuser = $data['kodeTerbesar'];

$urutan = (int) substr($kodeuser, 3, 2);
$urutan++;
$huruf = "usr";
$kodeuser = $huruf . sprintf("%02s", $urutan);

// jika ada tombol simpan
if (isset($_POST['simpan'])) {
    if (tambah_user($_POST) > 0) {
        header("Location: users.php?sukses=1");
        exit;
    } else {
        header("Location: users.php?gagal=1");
        exit;
    }
}

if (isset($_GET['sukses'])) {
    $alert = "<div class='alert alert-success' role='alert'>Data berhasil disimpan!</div>";
} elseif (isset($_GET['gagal'])) {
    $alert = "<div class='alert alert-danger' role='alert'>Data gagal disimpan!</div>";
} elseif (isset($_GET['hapus']) && $_GET['hapus'] == 'sukses') {
    $alert = "<div class='alert alert-success' role='alert'>Data berhasil dihapus!</div>";
} elseif (isset($_GET['hapus']) && $_GET['hapus'] == 'gagal') {
    $alert = "<div class='alert alert-danger' role='alert'>Data gagal dihapus!</div>";
}

include_once('templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data User</h1>

    <?= isset($alert) ? $alert : ''; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Data User</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $users = query("SELECT * FROM users");
                        foreach ($users as $user) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $user['username']; ?></td>
                                <td><?= $user['user_role']; ?></td>
                                                                <td class="text-nowrap">
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#gantiPassword" data-id="<?= $user['id_user'] ?>" title="Ganti Password">
                                        <i class="fas fa-key"></i> Password
                                    </button>
                                    <a class="btn btn-sm btn-warning" href="edit-user.php?id=<?= $user['id_user'] ?>" title="Ubah">
                                        <i class="fas fa-pen"></i> Ubah
                                    </a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger" href="hapus-user.php?id=<?= $user['id_user'] ?>" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="id_user" id="id_user" value="<?= $kodeuser ?>">
                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_role" class="col-sm-3 col-form-label">User Role</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="user_role" name="user_role">
                                <option value="admin">Administrator</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="gantiPassword" tabindex="-1" aria-labelledby="gantiPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gantiPasswordLabel">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <input type="hidden" name="id_user" id="id_user_password">
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                        <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include_once('templates/footer.php');
?>

<script>
$('#gantiPassword').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');

    $('#id_user_password').val(id);
});
</script>