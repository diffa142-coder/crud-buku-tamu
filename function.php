<?php
// panggil file koneksi.php
require_once('koneksi.php');

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

    $query = "INSERT INTO buku_tamu VALUES ('$kode','$tanggal','$nama_tamu','$alamat','$no_hp','$bertemu','$kepentingan')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

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

    $id_tamu     = mysqli_real_escape_string($koneksi, $id_tamu);
    $nama_tamu   = mysqli_real_escape_string($koneksi, $nama_tamu);
    $alamat      = mysqli_real_escape_string($koneksi, $alamat);
    $no_hp       = mysqli_real_escape_string($koneksi, $no_hp);
    $bertemu     = mysqli_real_escape_string($koneksi, $bertemu);
    $kepentingan = mysqli_real_escape_string($koneksi, $kepentingan);

    $query = "UPDATE buku_tamu SET
                nama_tamu = '$nama_tamu',
                alamat = '$alamat',
                no_hp = '$no_hp',
                bertemu = '$bertemu',
                kepentingan = '$kepentingan'
                WHERE id_tamu = '$id_tamu'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// function hapus data tamu
function hapus_tamu($id) {
    global $koneksi;

    $id = mysqli_real_escape_string($koneksi, $id);

    $query = "DELETE FROM buku_tamu WHERE id_tamu = '$id'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
// function tambah data user
function tambah_user($data){
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
