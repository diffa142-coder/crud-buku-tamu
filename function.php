<?php
// panggil file koneksi.php
require_once('koneksi.php');

// function upload gambar
function uploadGambar()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('File yang diunggah harus gambar!');</script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/upload_gambar/' . $namaFileBaru);

    return $namaFileBaru;
}

// membuat query ke / dari database
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function tambah data
function tambah_tamu($data)
{
    global $koneksi;

    $kode           = htmlspecialchars($data["id_tamu"]);
    $tanggal        = date("Y-m-d");
    $nama_tamu      = htmlspecialchars($data["nama_tamu"]);
    $alamat         = htmlspecialchars($data["alamat"]);
    $no_hp          = htmlspecialchars($data["no_hp"]);
    $bertemu        = htmlspecialchars($data["bertemu"]);
    $kepentingan    = htmlspecialchars($data["kepentingan"]);

    // upload gambar
    $gambar = uploadGambar();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO buku_tamu VALUES ('$kode','$tanggal','$nama_tamu','$alamat','$no_hp','$bertemu','$kepentingan','$gambar')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


// function ubah data tamu
// function ubah data tamu
function ubah($data)
{
    global $koneksi;

    $id_tamu     = htmlspecialchars($data["id_tamu"]);
    $nama_tamu   = htmlspecialchars($data["nama_tamu"]);
    $alamat      = htmlspecialchars($data["alamat"]);
    $no_hp       = htmlspecialchars($data["no_hp"]);
    $bertemu     = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);
    $gambarLama  = htmlspecialchars($data["gambarLama"]);

    $id_tamu     = mysqli_real_escape_string($koneksi, $id_tamu);
    $nama_tamu   = mysqli_real_escape_string($koneksi, $nama_tamu);
    $alamat      = mysqli_real_escape_string($koneksi, $alamat);
    $no_hp       = mysqli_real_escape_string($koneksi, $no_hp);
    $bertemu     = mysqli_real_escape_string($koneksi, $bertemu);
    $kepentingan = mysqli_real_escape_string($koneksi, $kepentingan);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = uploadGambar();
        if (!$gambar) {
            return false;
        }
    }

    $query = "UPDATE buku_tamu SET
                nama_tamu = '$nama_tamu',
                alamat = '$alamat',
                no_hp = '$no_hp',
                bertemu = '$bertemu',
                kepentingan = '$kepentingan',
                gambar = '$gambar'
                WHERE id_tamu = '$id_tamu'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function hapus data tamu
function hapus_tamu($id)
{
    global $koneksi;

    $id = mysqli_real_escape_string($koneksi, $id);

    $query = "DELETE FROM buku_tamu WHERE id_tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
// function tambah data user
function tambah_user($data)
{
    global $koneksi;

    $kode      = htmlspecialchars($data["id_user"]);
    $username  = htmlspecialchars($data["username"]);
    $password  = htmlspecialchars($data["password"]);
    $user_role = htmlspecialchars($data["user_role"]);

    $kode      = mysqli_real_escape_string($koneksi, $kode);
    $username  = mysqli_real_escape_string($koneksi, $username);
    $user_role = mysqli_real_escape_string($koneksi, $user_role);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users VALUES ('$kode','$username','$password_hash','$user_role')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ubah data user
function ubah_user($data)
{
    global $koneksi;

    $kode      = htmlspecialchars($data["id_user"]);
    $username  = htmlspecialchars($data["username"]);
    $user_role = htmlspecialchars($data["user_role"]);

    $kode      = mysqli_real_escape_string($koneksi, $kode);
    $username  = mysqli_real_escape_string($koneksi, $username);
    $user_role = mysqli_real_escape_string($koneksi, $user_role);

    $query = "UPDATE users SET
                username = '$username',
                user_role = '$user_role'
                WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function hapus data user
function hapus_user($id)
{
    global $koneksi;

    $id = mysqli_real_escape_string($koneksi, $id);

    $query = "DELETE FROM users WHERE id_user = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function ganti password user
function ganti_password($data)
{
    global $koneksi;

    $kode = htmlspecialchars($data["id_user"]);
    $password = htmlspecialchars($data["password"]);

    $kode = mysqli_real_escape_string($koneksi, $kode);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET
                password = '$password_hash'
                WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
