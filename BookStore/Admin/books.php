<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$books = $conn->query("
SELECT books.*, categories.name AS category
FROM books
LEFT JOIN categories ON books.category_id = categories.id
ORDER BY books.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Kelola Buku</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Kelola Buku</h1>

<br>

<a href="add_book.php" class="add-btn">
+ Tambah Buku
</a>

<br><br>

<table>

<tr>

<th>Cover</th>

<th>Judul</th>

<th>Penulis</th>

<th>Kategori</th>

<th>Harga</th>

<th>Stok</th>

<th>Aksi</th>

</tr>

<?php foreach($books as $book){ ?>

<tr>

<td>

<img src="../uploads/books/<?= $book['cover']; ?>" width="60">

</td>

<td><?= $book['title']; ?></td>

<td><?= $book['author']; ?></td>

<td><?= $book['category']; ?></td>

<td>Rp <?= number_format($book['price']) ?></td>

<td><?= $book['stock'] ?></td>

<td>

<a href="edit_book.php?id=<?= $book['id'] ?>">Edit</a>

|

<a href="delete_book.php?id=<?= $book['id'] ?>"
onclick="return confirm('Hapus buku?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>

</html>