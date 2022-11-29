<?php
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
//untuk halaman admin

require 'functions.php';

//ambil data dari tabel game online / query data
//mengurutkan data dengan order by
$gameonline = query("SELECT * FROM gameonline");
//tombol cari ditekan,timpa $gameonline dengan data game sesuai dengan pencarian
if (isset($_POST["cari"])) {
    //cari mahasiswa berdasarkan keyword
    $gameonline = cari($_POST["keyword"]);
}
//ambil data (fetch) gameonline dari object result
//mysqli_fetch_row() ==>>mengembalikan nilai array numerik
//mysqli_fetch_assoc() ==>>mengembalikan nilai array associative
//mysqli_fetch_array() ==>>mengembalikan nilai array numerik dan associative
//mysqli_fetch_object() ==>>mengembalikan object $gameol->Deskripsi

// while ($gameol = mysqli_fetch_assoc($result)) {
//     var_dump($gameol);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <a href="logout.php">logout</a>
    <h1>Daftar Game Online</h1>
    <p>Berikut Game online yang sudah atau pernah dimainkan</p>
    <a href="tambah.php">Tambah Game Online1</a>
    <br><br>

    <!-- mengurutkan data -->
    <form action="" method="post">
        <input type="text" name="keyword" size="35" autofocus placeholder="masukkan pencarian" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Publisher</th>
            <th>Developer</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($gameonline as $gameol) { ?>
            <tr>
                <td><?= $i ?></td>
                <td>
                    <a href="ubah.php?id=<?= $gameol["id"]; ?>">ubah</a> |
                    <a href="hapus.php?id=<?= $gameol["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
                </td>
                <td><img src="../img/<?= $gameol["gambar"] ?>" alt="" width="50"></td>
                <td><?= $gameol["nama"] ?></td>
                <td><?= $gameol["deskripsi"] ?></td>
                <td><?= $gameol["publisher"] ?></td>
                <td><?= $gameol["developer"] ?></td>
            </tr>
            <?php $i++; ?>
        <?php } ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>