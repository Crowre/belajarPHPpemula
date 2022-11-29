<?php
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
//koneksi ke DBMS

//ambil data di URL
$id = $_GET["id"];
//query data game online berdasarkan id
$gameol = query("SELECT * FROM gameonline WHERE id= $id")[0];

//check apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    //ambil data dari tiap elemen dalam form

    //query insert data

    //check apakah data berhasil diubah atau tidak
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php'
            </script>
            ";
    } else {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php'
            </script>
            ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <h1>Ubah Data Game Online</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $gameol["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $gameol["gambar"]; ?>">
        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $gameol["nama"]; ?>">
            </li>
            <li>
                <label for="deskripsi">Deskripsi :</label>
                <input type="text" name="deskripsi" id="deskripsi" required value="<?= $gameol["deskripsi"]; ?>">
            </li>
            <li>
                <label for="publisher">Publisher :</label>
                <input type="text" name="publisher" id="publisher" required value="<?= $gameol["publisher"]; ?>">
            </li>
            <li>
                <label for="developer">Developer :</label>
                <input type="text" name="developer" id="developer" required value="<?= $gameol["developer"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar :</label><br>
                <img src="../img/<?= $gameol['gambar']; ?>" alt=""><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>