<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$kategori = $conn->query("SELECT * FROM categories ORDER BY name ASC");

if(isset($_POST['save'])){

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $cover = "";

    if(isset($_FILES['cover']) && $_FILES['cover']['error']==0){

        $cover = time()."_".$_FILES['cover']['name'];

        move_uploaded_file(
            $_FILES['cover']['tmp_name'],
            "../uploads/books/".$cover
        );

    }

    $sql = $conn->prepare("INSERT INTO books
    (title,author,price,stock,description,cover,category_id)
    VALUES(?,?,?,?,?,?,?)");

    $sql->execute([
        $title,
        $author,
        $price,
        $stock,
        $description,
        $cover,
        $category
    ]);

    header("Location: books.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Tambah Buku</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Tambah Buku</h1>

<br>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Judul Buku</label>

<input
type="text"
name="title"
required>

<label>Penulis</label>

<input
type="text"
name="author"
required>

<label>Kategori</label>

<select name="category">

<?php foreach($kategori as $k){ ?>

<option value="<?= $k['id'] ?>">

<?= $k['name'] ?>

</option>

<?php } ?>

</select>

<label>Harga</label>

<input
type="number"
name="price"
required>

<label>Stok</label>

<input
type="number"
name="stock"
required>

<label>Deskripsi</label>

<textarea
name="description"
rows="6"></textarea>

<label>Cover Buku</label>

<input
type="file"
name="cover"
accept="image/*">

<br><br>

<button
class="save-btn"
name="save">

Simpan Buku

</button>

</form>

</div>

</div>

</body>

</html>