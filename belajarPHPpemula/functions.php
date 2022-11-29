<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");
//check koneksi conn
if (mysqli_connect_error()) {
    echo "Gagal terhubung ke MySQL :" . mysqli_connect_error();
}
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $publisher = htmlspecialchars($data["publisher"]);
    $developer = htmlspecialchars($data["developer"]);

    // $gambar = htmlspecialchars($data["gambar"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO gameonline 
    VALUES 
    ('','$nama','$deskripsi','$publisher',
    '$developer','$gambar')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
            alert('pilih gambar terlebih dahulu');
        </script>";
        return false;
    }

    //cek apakah file yang diupload itu gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('uploadlah gambar bukan file lain');
        </script>";
    }

    //cek jika ukuran gambar terlalu besar (<1MB)
    if ($ukuranFile > 10000000) {
        echo "<script>
            alert('ukuran gambar terlalu besar');
            </script>";
    }

    //lolos pengecekan dan gambar siap diupload
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmp_name, '../img/' . $namaFileBaru);




    return $namaFileBaru;
}
function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM gameonline WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    $publisher = htmlspecialchars($data["publisher"]);
    $developer = htmlspecialchars($data["developer"]);

    $gambarLama = htmlspecialchars($data["gambarLama"]);
    //check apakah user memilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE gameonline SET 
    nama ='$nama',
    deskripsi = '$deskripsi',
    publisher = '$publisher',
    developer = '$developer',
    gambar = '$gambar'
    WHERE id = $id
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM gameonline
    WHERE 
    nama LIKE '%$keyword%' OR
    publisher LIKE '%$keyword%' OR
    developer LIKE '%$keyword%'
    ";

    return query($query);
}

function registrasi($data)
{
    global $conn;
    //ambil data dan simpan data ke variabel
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);              //mysqli_real_escape_string untuk memungkinkan user memasukkan password karakter tertentu dan memasukkannya ke dalam database  
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    //note:
    //stripslashes untuk membersihkan username jika user memasukkan karakter tertentu misalnya backslases 
    //strtolower untuk  memaksakan input yang dimasukkan menjadi kecil semua 

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE 
        username='$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('user sudah terdaftar!');
        </script>";
        return false;
    }
    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('konfirmasi password tidak sesuai');
    </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password')");

    return mysqli_affected_rows($conn);
}
